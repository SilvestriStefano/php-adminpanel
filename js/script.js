let itemAccordion = document.querySelectorAll('.accordion-item'); //get all the accordion elements

        itemAccordion.forEach((el)=> { //for each of them
            el.children[0].addEventListener('click', function () { //when the title of the element is clicked (the first child is div.content-title)
                let siblings = this.parentElement.parentElement.children; //consider the array of all the accordion items 
                let index = Array.prototype.slice.call(siblings).indexOf(this.parentElement); //get the index of the clicked accordion item in the array
                for (let j = 0; j < siblings.length; j++) { //for each accordion item
                    if (j != index) { //except for this accordion item
                        let theContent = siblings[j].children[1]; //get the content
                        theContent.classList.add('hidden'); //and hide it
                    }
                }
                let content = this.nextElementSibling; //get the content of the clicked accordion item (remember we clicked on div.content-title)
                content.classList.toggle('hidden'); //and either hide or show it
            })
        })

