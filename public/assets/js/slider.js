window.addEventListener("load", function() {
    const slider = document.querySelector(".slider");
    const sliderMain = document.querySelector(".slider-main");
    const sliderItems = document.getElementsByClassName("slider-item");
    const nextBtn = document.querySelector(".slider-next");
    const prevBtn = document.querySelector(".slider-prev");
    const dotItems = document.getElementsByClassName("slider-dot-item");

    const sliderItemWidth = sliderItems[0].offsetWidth;
    const sliderLength = sliderItems.length;

    let positionX = 0;
    let index = 0;

    nextBtn.addEventListener("click", function() {
        handleChangeSlider(1);
    });

    prevBtn.addEventListener("click", function() {
        handleChangeSlider(-1);
    });

    [...dotItems].forEach((item) => 
        item.addEventListener("click", function(e) {

            [...dotItems].forEach((el) => el.classList.remove("active"));

            e.target.classList.add("active");

            const slideIndex = e.target.dataset.index;
            index = slideIndex;
            positionX = -1 * index * sliderItemWidth;
            sliderMain.style = `transform: translateX(${positionX}px)`;
        })
    ); 

    function handleChangeSlider(direction) 
    {
        if(direction === 1) {
            if(index >= sliderLength - 1) {
                index = sliderLength - 1;
                return;
            }
            positionX -= sliderItemWidth;
            sliderMain.style = `transform: translateX(${positionX}px)`;
            index++;
        }
        else if(direction === -1) {
            console.log("prev" + index);
            
            if(index <= 0) {
                index = 0;
                return;
            }
            positionX += sliderItemWidth;
            sliderMain.style = `transform: translateX(${positionX}px)`;
            index--;
        }

        [...dotItems].forEach((el) => el.classList.remove("active"));
        dotItems[index].classList.add("active");
    }
});