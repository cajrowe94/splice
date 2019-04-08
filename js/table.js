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

$(document).ready(function(){
  $.ajax({
        type: "GET",
        url: "../data/"+getQueryVariable("user")+"/"+getQueryVariable("filename"),
        dataType: "text",
        success: (data)=>{parseData(data);}
     });
});

let saveTable = () =>{
  console.log("works");
  console.log(table);
  table.download("csv", getQueryVariable("filename"));
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

  $("#title").html(">"+parsedData.data[0]['Input sequence ID']);
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
