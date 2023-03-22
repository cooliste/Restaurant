const nav = document.querySelector("#main");
const navTop = nav.offsetTop;
const navHeight = nav.offsetHeight;
const main = document.querySelector(".site-wrap");
const bars = document.querySelector("#bars");
const sidebar = document.getElementById("sidebar");

window.addEventListener("scroll", fixNav )

function fixNav(){
    
    if(window.scrollY >= navTop){

            nav.classList.add("fixed");
            main.style.paddingTop = navHeight + "px";
            sidebar.style.paddingTop = navHeight + "px";
           
  
      //sidebar.style.position = "fixed";
      //sidebar.style.position = "sticky";
            sidebar.classList.add("fixed-sidebar");

           
           
    }else{
            main.style.paddingTop = 0;
            sidebar.style.paddingTop = 0;
              nav.classList.remove("fixed");

            sidebar.classList.remove("fixed-sidebar");
    }
}

    
bars.addEventListener("click", function(){
    
    sidebar.classList.toggle("active");

})