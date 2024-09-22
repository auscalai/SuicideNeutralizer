let intro = document.querySelector('.intro');
let logo = document.querySelector('.logo-header');
let piclogo = document.querySelector('.piclogo');
let logoSpan = document.querySelectorAll('.splashlogo');
let welcomeSpan = document.querySelectorAll('.welcome');
let streakSpan = document.querySelector('.streak');

window.addEventListener('DOMContentLoaded', ()=>{
    function splashClick() {
        piclogo.classList.add('slide');
        logoSpan.forEach((span, idx)=>{
                span.classList.add('slide');
        });
        welcomeSpan.forEach((span, idx)=>{
                span.classList.add('slide');
        });
        streakSpan.classList.add('slide');

        setTimeout(()=>{

        piclogo.classList.remove('slide');
        piclogo.classList.add('fade');

        logoSpan.forEach((span, idx)=>{
            setTimeout(()=>{
                span.classList.remove('slide');
                span.classList.add('fade');
            },(idx + 1)*50)
        })

        welcomeSpan.forEach((span, idx)=>{
            setTimeout(()=>{
                span.classList.remove('slide');
                span.classList.add('fade');
            },150)
        })

        setTimeout(()=>{
            streakSpan.classList.remove('slide');
            streakSpan.classList.add('fade');
        },200 )

        setTimeout(()=>{
            intro.style.top ='-100vh';
        },500)

        },300);
        document.removeEventListener("click", splashClick);
      }

    document.addEventListener("click", splashClick);
      
    setTimeout(()=>{

        setTimeout(()=>{
            piclogo.classList.add('slide');
        })

        logoSpan.forEach((span, idx)=>{
            setTimeout(()=>{
                span.classList.add('slide');
            }, (idx + 1) * 400 )
        });

        setTimeout(()=>{
        welcomeSpan.forEach((span, idx)=>{
            
                setTimeout(()=>{
                    span.classList.add('slide');
                }, (idx + 1) * 400 )
        });
        },800)  


        setTimeout(()=>{
            streakSpan.classList.add('slide');
        },2000 )

        setTimeout(()=>{

            piclogo.classList.remove('slide');
            piclogo.classList.add('fade');

            logoSpan.forEach((span, idx)=>{

                setTimeout(()=>{
                    span.classList.remove('slide');
                    span.classList.add('fade');
                },(idx + 1)*50)
            })

            welcomeSpan.forEach((span, idx)=>{

                setTimeout(()=>{
                    span.classList.remove('slide');
                    span.classList.add('fade');
                },150)
            })

            setTimeout(()=>{
                streakSpan.classList.remove('slide');
                streakSpan.classList.add('fade');
            },200 )
    
        },2700);

        setTimeout(()=>{
            intro.style.top ='-100vh';
        },3000)

    })
})