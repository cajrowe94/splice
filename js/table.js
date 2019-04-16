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

$(document).ready(function(){
  $.ajax({
        type: "GET",
        url: "../data/"+getQueryVariable("user")+"/"+getQueryVariable("filename"),
        dataType: "text",
        success: (data)=>{
          parseData(data);
          //load saved data if it exists
          $.ajax({
            type: "HEAD",
            url: "../data/"+getQueryVariable("user")+"/table.json",
            success: (data)=>{
              table.setData("../data/"+getQueryVariable("user")+"/table.json")
              .then(()=>{
                console.log("Saved data loaded.");
                table.setData("../data/"+getQueryVariable("user")+"/table.json");
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
    url: "../includes/save.inc.php?user="+getQueryVariable("user"),
    dataType: "text",
    data: {data: JSON.stringify(tableData)},
    success: function(data){
        alert('Success');
    }
  });
};

//saves the current table layout
let exportTable = () => {
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
  let title = str.replace(/%20/g, " ");
  $("#title").html(title+" :: "+parsedData.data[0]['Input sequence ID']);
  //send table to be tabulated
  buildTable(parsedData.data);
}

//builds the table with the JSON object
let buildTable = tableData => {
  table = new Tabulator("#data-table", {
    height: "100%",
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
    rowClick: function(e, row){
      let data = row['_row']['data'];
      console.log(data);
      $(".acc-cell").text(data['Accession']);
      $(".id-cell").text(data['% identity']);
      $(".size-cell").text(data['Size']);
      $(".score-cell").text(data['E score']);
      data['confirm'] ? $(".confirm-cell").text("Yes") : $(".confirm-cell").text("No");
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
