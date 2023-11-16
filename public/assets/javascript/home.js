document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('map').setView([
    50.62925, 3.057256
    ], 13); // Coordonnées de Lille
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 19}).addTo(map);
    
    var metroStations = [  // mon objet qui contient toutes les stations pour comparer avec la bdd pour afficher les warning sur la carte
    {  
    name: "PORTE DES POSTES",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.618418, 3.050267]
    },
    {
    name: "GARE LILLE FLANDRES",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.636316, 3.070668]
    },
    {
    name: "SQUARE FLANDRES",
    commune: "HELLEMMES (LILLE)",
    insee: "298",
    ligne: "1",
    coordinates: [50.62518, 3.116077]
    },
    {
    name: "PONT DE BOIS",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "1",
    coordinates: [50.624238, 3.128045]
    }, {
    name: "MONTEBELLO",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.622046, 3.045442]
    }, {
    name: "LOMME LAMBERSART NOTEBART",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.640725, 3.018327]
    }, {
    name: "MAISON DES ENFANTS",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.646327, 2.995229]
    }, {
    name: "GARE LILLE EUROPE",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.639194, 3.075687]
    }, {
    name: "ALSACE",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.70042895512235, 3.1612353955027976]
    }, {
    name: "GARE DE TOURCOING",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.7168587058013, 3.1626435867422713]
    }, {
    name: "TOURCOING CENTRE",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.7211768819679, 3.1599694749987712]
    }, {
    name: "COLBERT",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.72527609997598, 3.15684419999602]
    }, {
    name: "PHALEMPINS",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.732437377307726, 3.157824674473719]
    }, {
    name: "C.H. DRON",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.74375924636108, 3.1804992650825517]
    }, {
    name: "CAULIER",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.63664343107725, 3.087311816870864]
    }, {
    name: "VILLENEUVE D'ASCQ HOTEL DE VILLE",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "1",
    coordinates: [50.61874880244155, 3.131449514033679]
    }, {
    name: "PONT SUPERIEUR",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.64467142602714, 3.013716721137652]
    }, {
    name: "BOURG",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.64559973973597, 2.98522811480942]
    }, {
    name: "LES PRES EDGARD PISANI",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "2",
    coordinates: [50.650063237298426, 3.1264210237785015]
    }, {
    name: "EUROTELEPORT",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.691433870722, 3.180185492927226]
    }, {
    name: "MERCURE",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.70474957868657, 3.160611846530091]
    }, {
    name: "BOURGOGNE",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.73956082493749, 3.179623429990607]
    }, {
    name: "PORTE DES POSTES",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.618418, 3.050267]
    }, {
    name: "GAMBETTA",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.626399197505776, 3.052253532242168]
    }, {
    name: "MARBRERIE",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.63021146343522, 3.0977123983627624]
    }, {
    name: "CITE SCIENTIFIQUE PR GABILLARD",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "1",
    coordinates: [50.61179044741962, 3.1424211448540977]
    }, {
    name: "MAIRIE DE LILLE",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.63271972852851, 3.0708335745715187]
    }, {
    name: "LILLE GRAND PALAIS",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.629381986592534, 3.0752004897828615]
    }, {
    name: "CORMONTAIGNE",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.62617165544624, 3.0402836361085304]
    }, {
    name: "PORT DE LILLE",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.630014019287266, 3.035392479338205]
    }, {
    name: "CANTELEU",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.63710902400898, 3.024584195000346]
    }, {
    name: "SAINT PHILIBERT",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.651900029215724, 2.9744976442288316]
    }, {
    name: "CHU EURASANTE",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.60810067453187, 3.0389626927225755]
    }, {
    name: "RIHOUR",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.63564949936589, 3.062725582743005]
    }, {
    name: "MAIRIE D'HELLEMMES",
    commune: "HELLEMMES (LILLE)",
    insee: "298",
    ligne: "1",
    coordinates: [50.62716581800207, 3.1092192474634146]
    }, {
    name: "TRIOLO",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "1",
    coordinates: [50.61687433183069, 3.140650240859725]
    }, {
    name: "4 CANTONS STADE PIERRE MAUROY",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "1",
    coordinates: [50.605388382147304, 3.139041435053113]
    }, {
    name: "BOIS BLANC",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.63443120651534, 3.0305501415160476]
    }, {
    name: "SAINT MAURICE PELLEVOISIN",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.64244894896162, 3.0885072854932103]
    }, {
    name: "MONS SART",
    commune: "MONS EN BAROEUL",
    insee: "410",
    ligne: "2",
    coordinates: [50.642081529985944, 3.0989726687556027]
    }, {
    name: "FORT DE MONS",
    commune: "MONS EN BAROEUL",
    insee: "410",
    ligne: "2",
    coordinates: [50.642061984912516, 3.1194353452049994]
    }, {
    name: "CROIX CENTRE",
    commune: "CROIX",
    insee: "163",
    ligne: "2",
    coordinates: [50.67429597931637, 3.1463640235441956]
    }, {
    name: "GARE JEAN LEBAS ROUBAIX",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.69568410277324, 3.163981788374818]
    }, {
    name: "CARLIERS",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.71082902686108, 3.159909157375728]
    }, {
    name: "CHU CENTRE OSCAR LAMBRET",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.61316647879058, 3.0362116795553047]
    }, {
    name: "WAZEMMES",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.62307218147788, 3.0522820115602336]
    }, {
    name: "REPUBLIQUE BEAUX ARTS",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.631515047132986, 3.0602919497585725]
    }, {
    name: "FIVES",
    commune: "LILLE",
    insee: "350",
    ligne: "1",
    coordinates: [50.6329428522101, 3.09067342597185]
    }, {
    name: "PORTE DE VALENCIENNES",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.62105530406313, 3.078879468581744]
    }, {
    name: "PORTE DE DOUAI",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.61823230300241, 3.072975049975215]
    }, {
    name: "PORTE D'ARRAS",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.61762075224161, 3.0622890996375483]
    }, {
    name: "MITTERIE",
    commune: "LOMME (LILLE)",
    insee: "355",
    ligne: "2",
    coordinates: [50.64684337204293, 3.0077713459324156]
    }, {
    name: "MAIRIE DE MONS",
    commune: "MONS EN BAROEUL",
    insee: "410",
    ligne: "2",
    coordinates: [50.642320529194826, 3.1097874322774723]
    }, {
    name: "JEAN JAURES",
    commune: "VILLENEUVE D'ASCQ",
    insee: "009",
    ligne: "2",
    coordinates: [50.658462119085726, 3.1349685309866193]
    }, {
    name: "WASQUEHAL PAVE DE LILLE",
    commune: "WASQUEHAL",
    insee: "646",
    ligne: "2",
    coordinates: [50.663989207322814, 3.130473867134851]
    }, {
    name: "WASQUEHAL HOTEL DE VILLE",
    commune: "WASQUEHAL",
    insee: "646",
    ligne: "2",
    coordinates: [50.66986642672279, 3.131323766112838]
    }, {
    name: "MAIRIE DE CROIX",
    commune: "CROIX",
    insee: "163",
    ligne: "2",
    coordinates: [50.67907340631418, 3.1558668648080586]
    }, {
    name: "EPEULE MONTESQUIEU",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.6840279650543, 3.1634656499223457]
    }, {
    name: "ROUBAIX CHARLES DE GAULLE",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.68665657135784, 3.1700281591156894]
    }, {
    name: "ROUBAIX GRAND PLACE",
    commune: "ROUBAIX",
    insee: "512",
    ligne: "2",
    coordinates: [50.69168709021787, 3.1744650378702612]
    }, {
    name: "PONT DE NEUVILLE",
    commune: "TOURCOING",
    insee: "599",
    ligne: "2",
    coordinates: [50.73686067271237, 3.1707827279324747]
    }, {
    name: "GARE LILLE FLANDRES",
    commune: "LILLE",
    insee: "350",
    ligne: "2",
    coordinates: [50.636569206998296, 3.0700053201517683]
    }
    ];
    
    // Créez des icônes personnalisées pour chaque ligne
    var yellowIcon = L.icon({
    iconUrl: './assets/images/marker-svgrepo-comY.svg', // les icone jaune de la ligne 1 
    iconSize: [
    25, 41
    ], // Taille de l'icône
    iconAnchor: [
    12, 41
    ], // Point d'ancrage de l'icône
    popupAnchor: [0, -41] // Point d'ancrage de la popup
    });
    
    var redIcon = L.icon({ 
    iconUrl: './assets/images/marker-svgrepo-comR.svg',
    iconSize: [
    25, 41
    ],
    iconAnchor: [
    12, 41
    ],
    popupAnchor: [0, -41]
    });
    
    var warningIcon = L.icon({  
        iconUrl: './assets/images/warning-svgrepo-com.svg',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [0, -41]
    });
    // Boucle pour ajouter des marqueurs pour chaque station de métro
    for (var i = 0; i < metroStations.length; i++) {
    var station = metroStations[i];
    
    // Créez le contenu de la popup pour la station
    var popupContent = "Station de métro " + station.name + ", " + station.commune;
    
    // Créez le marqueur avec l'icône appropriée en fonction de la ligne
    var markerIcon = (station.ligne === "1") ? yellowIcon : redIcon;
    var marker = L.marker(station.coordinates, {icon: markerIcon}).addTo(map).bindPopup(popupContent);
    
    // Vous pouvez également ouvrir la popup par défaut si vous le souhaitez
    if (i === 0) {
    marker.openPopup(); 
    }
    console.log(metroStations[i].name); // on va les comparer a celle de l'objet present sur la carte 
    }
// liste d'éléments <td> dans variable tdElements
var tdElements = document.querySelectorAll('.metro-station'); // les elements td c'est la ou il y a les stations de la bdd

// Boucle sur chaque élément <td>
tdElements.forEach(function (tdElement) {
    // Extraire le texte de l'élément <td> et le nettoyer
    var tdValue = tdElement.innerText.replace(/-\s*Ligne\s*\d*\s*$/, '').trim(); // cette ligne va enlever les espaces et "- ligne 1/2"

    // Afficher la valeur nettoyée de l'élément <td> dans la console
    console.log("Valeur nettoyée de l'élément <td> :", tdValue);// affiche la valeur td sans - ligne ect...

    // Boucle sur les valeurs du tableau metroStations (l'objet)
    for (var i = 0; i < metroStations.length; i++) {
        // Comparer avec la valeur nettoyée de l'élément <td>
        if (tdValue == metroStations[i].name) {
            // console.log("Correspondance trouvée pour l'élément :", metroStations[i].name);

            // Créer le contenu de la popup pour la station
            var popupContent = "Station de métro " + metroStations[i].name + ", " + metroStations[i].commune;

            // Choisir l'icône en fonction de la ligne
            var markerIcon = warningIcon;

            // Afficher le chemin de l'icône dans la console
            // console.log("Chemin de l'icône :", markerIcon.options.iconUrl);

            // Ajouter le marker avec l'icône appropriée
            var marker = L.marker(metroStations[i].coordinates, { icon: markerIcon }).addTo(map).bindPopup(popupContent);

            // Sortir de la boucle une fois qu'une correspondance est trouvée
            break;
        }
    } // tout ça pour afficher un warning sur les stations presentes dans un ou plusieurs post sur la carte
});


// afficher les coordonnées gps au clique sur la carte 
    map.on('click', function (e) {
    alert("Coordonnées du clic : " + e.latlng.toString()); 

    });
    
    });
    
    // affiche le modale pour commenter les posts 
    document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('open-comment-modal')) {
    const postId = e.target.getAttribute('data-post-id'); // Récupérer l'ID du post
    const modal = document.querySelector('#createCommentModal');
    
    // Mettre à jour le formulaire avec l'ID du post
    const form = modal.querySelector('form');
    const action = form.getAttribute('action');
    form.setAttribute('action', action.replace('__postId__', postId));
    
    // Ouvrir le modal
    $('#createCommentModal').modal('show'); // pour ouvir l'input de commentaire et mettre le commentaire sous le post concerner
    
    }
    });
    console.log(postId);
    
    var commentForm = document.querySelector('#createCommentModal form');
    var commentButton = document.querySelector('.open-comment-modal');
    var commentModal = new bootstrap.Modal(document.getElementById('createCommentModal'));
    
    if (commentForm) {
    commentForm.addEventListener('submit', function (e) {
    e.preventDefault();
    commentModal.hide();
    // Réinitialiser le formulaire après l'envoi
    commentForm.reset();
    });
    }


