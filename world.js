$( document ).ready( function () {
    $("#country-lookup").click(() => search_country(city = false));
    $("#city-lookup").click(() => search_country(city = true));
});

const baseURI = "http://localhost:8080/world.php";


function search_country(city = False){
    let query = $("#country").val().trim();
    console.log(city);
    let url = ``;
    if( city ) {
        url = `${baseURI}?country=${query}&context=cities`;
    } else {
        url = `${baseURI}?country=${query}`;
    }
    
    console.log(url);
    fetch(url, {method: 'GET'})
    .then(response => response.text())
    .then(data => $("#result").html(data))
    .catch(error => alert(error));
}