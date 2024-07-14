// ##################################################################################################

//                                  DIVS animation

// ##################################################################################################


    // Select all div elements with class name "my-div"
const divs = document.querySelectorAll('.widget');

// Define the animation properties
const animation = anime({
    targets: divs, // Elements to animate
    opacity: 1, // Target opacity to animate to
    translateY: ['100%', '0%'], // Animation for translation on Y-axis
    duration: 1000, // Animation duration in milliseconds
    delay: anime.stagger(100), // Delay between each animation (staggered effect)
    easing: 'easeInOutQuad' // Easing function for the animation
});

const btnavi = document.querySelectorAll('.navicon');

        // Define the animation properties
const navianimation = anime({
    targets: btnavi, // Elements to animate
    opacity: 1, // Target opacity to animate to
    translateY: ['100%', '0%'], // Animation for translation on Y-axis
    duration: 1000, // Animation duration in milliseconds
    delay: anime.stagger(100), // Delay between each animation (staggered effect)
    easing: 'easeInOutQuad' // Easing function for the animation
});


// ##################################################################################################

//                                  Button animations

// ##################################################################################################

var btlogout = document.getElementById("logoutbutton");
var btadmin = document.getElementById("adminbutton");
var btprofile = document.getElementById("profilebutton");
var bthome = document.getElementById("homebutton");
        
btlogout.onmouseover = function(event){
    toggleDivs();

}
function toggleDivs() {
    if (bthome.style.opacity === '0') {
        anime({
        targets: ['.navicon'],
        opacity: 1,
        translateX: '0px',
        duration: 500,
        easing: 'easeOutExpo',
        delay: anime.stagger(100)
        });
    } else {
        anime({
        targets: ['.navicon'],
        opacity: 0,
        translateX: '50px',
        duration: 500,
        easing: 'easeOutExpo',
        delay: anime.stagger(100)
        });
    }
}
function nopacity(){
    bthome.style.opacity = 0;
    btprofile.style.opacity = 0;
    btadmin.style.opacity = 0;
}
window.onload = function() {
    setTimeout(() => {  toggleDivs(); }, 3000);
};


