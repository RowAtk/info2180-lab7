$( document ).ready( function () {
    $("#lookup").click(search_country)
});

const baseURI = "http://localhost:8080/world.php";


function search_country(){
    let query = $("#country").val().trim();
    console.log(query);
    const url = `${baseURI}?country=${query}`;
    console.log(url);
    fetch(url, {method: 'GET'})
    .then(response => console.log(response))
}