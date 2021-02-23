
// Permet de gérer la mise en favori reversible d'un element
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


// Fonction activant les tooltips (affiche les noms complets des modules en survol)

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Fonction permettant de signaler utilisant l'ajax
function onClickSignaler(event){

    event.preventDefault();

    const url = this.href;

    axios.get(url).then(function(response){
        // Disable le bouton signaler
        event.srcElement.className += ' disabled';
    })        
}

 signaler = document.querySelector('a.signaler')
 if (signaler != null) signaler.addEventListener('click', onClickSignaler);
