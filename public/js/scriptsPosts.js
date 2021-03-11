
// Permet de gérer la mise en favori reversible d'un element
function onClickStarFavori(event){

    event.preventDefault();

    const url = this.href;
    const icone = this.querySelector('i');

    axios.get(url).then(function(response){

    	if(icone.classList.contains('fas')) {
    		icone.classList.replace('fas','far'); // etoile vide
            icone.classList.add('grise');        // etoile grise
    		
    	} else {
    		icone.classList.replace('far','fas'); // etoile pleine
            icone.classList.remove('grise');    // etoile dorée
    		var element = document.getElementById('js-fav-text').innerHTML=""; // enlever text "mettre en favori"
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

// Fonction qui permet de noter un post dynamiquement en ajax
 function onClickNoter(event){

    event.preventDefault();


        const anchor = this.querySelector('a'); // tag qui contient le path pour enregistrer la note
        url = anchor.href; // route à declencher en ajax

        // récupération de la note qui vient d'être cliquée
        const note = $(".starrr").data('starrr').options.rating;

        // on remplace la valeur 'placeholder' dans la route par la note attribuée
        url = url.replace('noteARemplacer', note);

        console.log(url);
        axios.get(url).then(function(response){
        }) 

    }
   
    noter = document.querySelector('div.starrr')
    if (noter != null) noter.addEventListener('click', onClickNoter);


// Permet de mettre une image par défaut sur toutes les liens d'images cassés 

    fixBrokenImages = function( url ){
        var img = document.getElementsByTagName('img');
        var i=0, l=img.length;
        for(;i<l;i++){
            var t = img[i];
            if(t.naturalWidth === 0){
                //this image is broken
                t.src = url;
            }
        }
    }

    window.onload = function() {
    fixBrokenImages('https://screenshotlayer.com/images/assets/placeholder.png');
    }