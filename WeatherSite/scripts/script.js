window.onload = function() {
  let aLink = document.getElementsByTagName("a");
  document.querySelector('#button').addEventListener("click", function(event){
    event.preventDefault();
    validateForm();
  }, false);
  for (let i = 0; i < aLink.length ; i++) {
      aLink[i].addEventListener("click", function (event) {
              event.preventDefault();
              fetchData(event.currentTarget.getAttribute('name'));
    },false);
  }
};
/* Know error: blir lite konstigt när man söker på sin fjärde stad, oklart vad som händer men efter det funkar det perkeft*/
function validateForm(){
  let box = document.getElementById('box');
  let inp = box.value.toLowerCase();
  inp = capitalizeLetter(inp);
  console.log(inp);
  let errClass = document.getElementById('errorMsg');
  if(inp.length == 0){
    if(!errClass.classList.contains('errorCity')){
    let pTag = document.createElement("P");
    let text = document.createTextNode("Please enter a city.");
    errClass.innerHTML = "";
    pTag.appendChild(text);
    errClass.appendChild(pTag);
    errClass.classList.replace("hide-err", "errorCity");
    box.focus();
    }
  }else{
    fetchData(inp);
  }
}

function fetchData(city){
  fetch('https://api.openweathermap.org/data/2.5/weather?q=' + city + '&units=metric&appid=426f2c819091f6ff649c54a7b1a7b3f8', {
    method: 'get'
  })
  .then((response) =>{
  if(response.ok){
    return response.json();
  }else{
    throw new Error('Something went wrong!');
  }
})
  //.then(response => response.json())
  .then(jsonData => {
    saveData(jsonData, city);
  })
  .catch(err => {
    let errClass = document.getElementById('errorMsg');
    let pTag = document.createElement("P");
    let text = document.createTextNode(err);
    errClass.innerHTML = "";
    pTag.appendChild(text);
    errClass.appendChild(pTag);
    errClass.classList.replace("hide-err", "errorSearch");
    box.focus();
  })
}

function saveData(data, city){
  let weatherData = document.getElementById('weatherData');
  document.getElementById('searchWrap').classList.replace('show', 'hide');
  weatherData.classList.replace('hide-data', 'show');
  let temp = data.main.temp;
  let weatherMain = data.weather[0].main;
  let wind = data.wind.speed;
  let comment = getComment(temp);

  //replace and write weather
  weatherData.innerHTML = weatherData.innerHTML.replace('---city---', city);
  weatherData.innerHTML = weatherData.innerHTML.replace('---comment---', comment);
  weatherData.innerHTML = weatherData.innerHTML.replace('---temp---', temp);
  weatherData.innerHTML = weatherData.innerHTML.replace('---main---', weatherMain);
  weatherData.innerHTML = weatherData.innerHTML.replace('---wind---', wind);
  city = city + ",";

  if(!document.cookie){
    document.cookie = "cities=" + city;
  }else{
    document.cookie = document.cookie + city;
    let splitArray = document.cookie.split('=');
    splitArray.shift();
    let stringToSplit = splitArray.toString();
    splitArray = stringToSplit.split(',');
    splitArray.pop();
    if(splitArray.toString().includes(city)){
      splitArray = splitArray.filter((value, index) => splitArray.indexOf(value) === index);
      document.cookie = 'cities=' + splitArray.reverse().toString() + ',';
    }
    if(splitArray.length > 3){
      splitArray.shift();
      document.cookie = 'cities=' + splitArray.reverse().toString() + ',';
    }
    document.cookie = 'cities=' + splitArray.reverse().toString() + ',';
    //ta bort sista om det är 3
  }
}
function capitalizeLetter(city){
  let citySplit = city.toLowerCase().split(' ');
  for(let i = 0; i < citySplit.length; i++){
    citySplit[i] = citySplit[i].charAt(0).toUpperCase() + citySplit[i].substring(1);
  }
  return citySplit.join(' ');
}
function getComment(temp){
  let comment = "";
  let xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status === 200){
      document.getElementById('weatherData').innerHTML = weatherData.innerHTML.replace('---comment---', this.responseText);
    }
  };
  xmlhttp.open("GET", "dbFunctions.php?temp=" + temp, false); //borde vara true, funkar bara med false i nulägget
  xmlhttp.send();
}
