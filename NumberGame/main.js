function printOutput(){
  document.getElementById('id')
}
var card = document.getElementsByClassName("card");
for(var i = 0; i < card.length; i++){
  card[i] = Math.floor(Math.random() * 18) + 1;
}
for(var i = 18; i < card.length; i++){
  card[i] = Math.floor(Math.random() * 18) + 1;
}
