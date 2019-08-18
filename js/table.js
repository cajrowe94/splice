let table; //holds the table data
let parsedData; //holds the parsed csv file
let csvFile; //holds the csv file
//link for the proteins
const link = 'https://www.ncbi.nlm.nih.gov/protein/';
//title of the protein
//let title = document.getElementById('title');
//these are used to build the path directory
let user;
let filename;
let tableData;
//current selected row
let currentRow;

$(document).ready(function(){
  $('.comment-box').css("display", "none");

  if (window.history.replaceState){
        window.history.replaceState(null, null, window.location.href);
  }

  let closeLink = document.getElementById("close-comments");
  closeLink.addEventListener("click",function(){
    $('.comment-box').css("display", "none");
  });

  $('.comment-box-body').css("visibility", "hidden");
  $('textarea[name="message"]').hide();
  $('#submit-comment').hide();
  $.ajax({
    type: "GET",
    url: "../data/"+getQueryVariable("user")+"/"+getQueryVariable("filename"),
    dataType: "text",
    success: (data)=>{
      parseData(data);
      //load saved data if it exists
      $.ajax({
        type: "HEAD",
        url: "../data/"+getQueryVariable("user")+"/"+getQueryVariable("title")+"_save.json",
        success: (data)=>{
          table.setData("../data/"+getQueryVariable("user")+"/"+getQueryVariable("title")+"_save.json")
          .then(()=>{
            console.log("Saved data loaded.");
            table.setData("../data/"+getQueryVariable("user")+"/"+getQueryVariable("title")+"_save.json");
          })
          .catch(()=>{
            console.log("No saved data found.");
          });
        }
      });
    }
  });
});

//saves the current table layout
let saveTable = () => {
  tableData = table.getData();
  $.ajax({
    type: "POST",
    url: "../includes/save.inc.php?user="+getQueryVariable("user")+"&title="+getQueryVariable("title"),
    dataType: "text",
    data: {data: JSON.stringify(tableData)},
    success: function(data){
        $("#save-table").css("background", "#20FF17").text("Save ✔");
    }
  });
};

//saves the current table layout
let exportTable = () => {
  saveTable();
  table.download("csv", getQueryVariable("user")+"_table.csv");
};

//https://css-tricks.com/snippets/javascript/get-url-variables/
function getQueryVariable(variable){
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
         var pair = vars[i].split("=");
         if(pair[0] == variable){return pair[1];}
  }
  return(false);
}

//convert the csv file into a JSON object
let parseData = data => {
  parsedData = Papa.parse(data, {
    header: true
  });
  //remove empty objects at the end of the array
  parsedData.data.splice(parsedData.data.length-1, 1);
  let str = getQueryVariable("title");
  let title = str.replace(/%20/g, " ").replace(/%27/g, "'");
  $("#title").html(title+" :: "+parsedData.data[0]['Input sequence ID']);
  //send table to be tabulated
  buildTable(parsedData.data);
}

//handles posting comments
let postComment = () => {
  $("#save-table").css("background", "#3f3fea").text("Save");
}

//builds the table with the JSON object
let buildTable = tableData => {
  table = new Tabulator("#data-table", {
    height: "75vh",
    layout: "fitColumns",
    data: tableData,
    columns:[
        {title:"Accession", field:"Accession", align:"center",  formatter:function(cell, formatterParams){
          let val = cell.getValue();
          return "<a href=\"" + link + val + "\" target='_blank' style='text-decoration:none;'>" + val + "</a>";
        }, resizable: false},
        {title:"% identity", field:"% identity", align:"center"},
        {title:"Size", field:"Size", align:"center"},
        {title:"E score", field:"E score", align:"center"},
        {title:"Confirm", field:"confirm", align:"center", editor:true, formatter:"tickCross"},
    ],
    selectable: 1,
    rowClick: function(e, row){
      $('.comment-box').css("display", "block");
      currentRow = row['_row']['data'];
      let id = currentRow['Accession']+currentRow['% identity'];
      let currentID = id.replace(/[._]/g,'');
      console.log(currentID);
      //only show the comment menu when a row is clicked
      $('textarea[name="message"]').show();
      $('#submit-comment').show();
      //set the rowid after each new click
      $('input[name="rowId"]').attr("value", currentID);
      //reset save button
      $("#save-table").css("background", "#3f3fea").text("Save");
      $(".acc-cell").text(currentRow['Accession']);
      $(".id-cell").text(currentRow['% identity']);
      $(".size-cell").text(currentRow['Size']);
      $(".score-cell").text(currentRow['E score']);
      currentRow['confirm'] ? $(".confirm-cell").text("Yes") : $(".confirm-cell").text("No");
      //make the comment body visible
      $('.comment-box-body').css("visibility", "visible");
      //get all comments in an object
      let comments = document.getElementsByClassName("comment");
      //console.log(comments[0]['classList'][1]);
      //loop through each comment
      for (let i = 0; i < comments.length; i++){
        let activeID = comments[i]['classList'][1];
        //if the id matches current selected row
        if (activeID == currentID){
          console.log(activeID+" matches "+currentID);
          $('.'+activeID).css("display", "block");
        } else {
          console.log(activeID+" does not match "+currentID);
          $('.'+activeID).css("display", "none");
        }
      }
    },
  });
}

//credit: https://stackoverflow.com/questions/1531093/how-do-i-get-the-current-date-in-javascript
let getTodaysDate = () => {
  let today = new Date();
  let dd = String(today.getDate()).padStart(2, '0');
  let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  let yyyy = today.getFullYear();

  today = mm + '/' + dd + '/' + yyyy;
  return today;
}
