window.scrollReveal = ScrollReveal({ reset:false});

    scrollReveal.reveal('#animation-left', {
        duration: 1500,
        origin: 'left',
        distance: '50px'
    });

    scrollReveal.reveal('#animation-center', {
        duration: 1500,
        origin: 'center',
        distance: '50px'
    });

    scrollReveal.reveal('#animation-right', {
        duration: 1500,
        origin: 'right',
        distance: '50px'
    });

    scrollReveal.reveal('.animation-reveal', {
        duration: 1600,
        origin: 'bottom',
        distance: '200px'
    });