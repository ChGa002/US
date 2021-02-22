function onClickStarFavori(event){

 event.preventDefault();

 const url = this.href;
const icone = this.querySelector('i');

 axios.get(url).then(function(response){

 if(icone.classList.contains('fas')) {
icone.classList.replace('fas','far');
} else {
icone.classList.replace('far','fas');
var element = document.getElementById('js-fav-text').innerHTML="";
}
})
}

 document.querySelectorAll('a.js-favori').forEach(function(link){

 link.addEventListener('click', onClickStarFavori);

 })