document.addEventListener('DOMContentLoaded', function() {
  convertImages('img.injectable');
  mobileMenu();
  accordion();
  smoothScroll();
  documentsNavigation();
});

const convertImages = (query, callback) => {
  const images = document.querySelectorAll(query);
  images.forEach(image => {
    fetch(image.src)
      .then(res => res.text())
      .then(data => {
        const parser = new DOMParser();
        const svg = parser.parseFromString(data, 'image/svg+xml').querySelector('svg');

        if (!svg) throw new Error('SVG not found');

        if (image.id) svg.id = image.id;
        if (image.className) svg.classList = image.classList;

        image.parentNode.replaceChild(svg, image);
      })
      .then(() => {
        if (typeof callback === 'function') callback();
      })
      .catch(error => console.error(error));
  });
};

function mobileMenu() {
  document.querySelector('.rd-header-mobile').addEventListener('click', function() {
    this.classList.toggle('open');

    document.querySelector('.rd-header-mobile-menu').classList.toggle('open');

    //Attach rd-icon--handler click handlers
    document.querySelectorAll('.rd-icon--handler').forEach(function(icon) {
      icon.addEventListener('click', function(e) {
        e.stopPropagation(); // prevent event bubbling if needed
        e.preventDefault(); // prevent default
        // Find closest ancestor with class 'rd-header-menu-top__link'
        let linkParent = icon.closest('.rd-header-menu-top__link ');
        linkParent.classList.toggle('open');
        
        if (linkParent) {
          // Find the next sibling ul after .rd-header-menu-top__link parent
          let nextUl = linkParent.nextElementSibling;
          if (nextUl && nextUl.tagName.toLowerCase() === 'ul') {
            nextUl.classList.toggle('open');
          }
        }
      });
    });
  });
}

function accordion() {
  document.querySelectorAll('.rd-faq').forEach(main => {
    main.querySelectorAll('.rd-faq-item').forEach(item => {
      const question = item.querySelector('.rd-faq-question');

      question.addEventListener('click', () => {
        const isOpen = item.classList.contains('open');

        // Close all
        document.querySelectorAll('.rd-faq-item.open').forEach(openItem => {
          openItem.classList.remove('open');
        });

        // Toggle current
        if (!isOpen) {
          item.classList.add('open');
        }
      });
    });
    // Open first item by default
    const firstItem = document.querySelector('.rd-faq-item');
    if (firstItem) {
      firstItem.classList.add('open');
    }
  });
}

function smoothScroll(offset = 160) {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach(link => {
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);

      if (targetElement) {
        e.preventDefault();

        const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
        const offsetPosition = elementPosition - offset;

        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
      }
    });
  });
}

function documentsNavigation() {
  const materialBlocks = document.querySelectorAll('.rd-material');

  if (!materialBlocks.length) {
    return;
  }

  const toEmbedUrl = (url) => {
    if (!url) {
      return '';
    }

    const value = url.trim();

    if (value.includes('youtu.be/')) {
      const videoId = value.split('youtu.be/').pop().split('?')[0];
      return `https://www.youtube.com/embed/${videoId}`;
    }

    if (value.includes('youtube.com')) {
      const videoId = value.includes('v=') ? value.split('v=').pop().split('&')[0] : '';
      return videoId ? `https://www.youtube.com/embed/${videoId}` : value;
    }

    if (value.includes('vimeo.com/')) {
      const videoId = value.split('vimeo.com/').pop().split('?')[0];
      return `https://player.vimeo.com/video/${videoId}`;
    }

    return value;
  };

  materialBlocks.forEach((block) => {
    const links = block.querySelectorAll('.rd-material-document__link');
    if (!links.length) {
      return;
    }

    const setActiveLink = (activeLink) => {
      links.forEach((item) => item.classList.remove('active'));
      activeLink.classList.add('active');
    };

    setActiveLink(links[0]);

    links.forEach((link) => {
      link.addEventListener('click', (event) => {
        event.preventDefault();
        setActiveLink(link);

        const videoTitle = link.getAttribute('videotitle') || '';
        const formLink = link.getAttribute('formlink') || '';
        const videoLink = link.getAttribute('videolink') || '';
        const videoTranscript = link.getAttribute('videotranscript') || '';

        const videoWrapper = block.querySelector('.rd-material-video-wrapper');
        if (videoWrapper) {
          let iframe = videoWrapper.querySelector('iframe');
          if (!iframe) {
            iframe = document.createElement('iframe');
            iframe.setAttribute('width', '100%');
            iframe.setAttribute('frameborder', '0');
            iframe.setAttribute('allowfullscreen', '');
            videoWrapper.innerHTML = '';
            videoWrapper.appendChild(iframe);
          }

          iframe.setAttribute('src', toEmbedUrl(videoLink));
        }

        const formButton = block.querySelector('.rd-material__button');
        if (formButton && formLink) {
          formButton.setAttribute('href', formLink);
        }

        const transcript = block.querySelector('.rd-material-transcript');
        if (transcript) {
          transcript.innerHTML = videoTranscript;
        }

        const title = block.querySelector('.rd-material__title');
        if (title) {
          title.innerHTML = videoTitle;
        }
      });
    });
  });
}

(function ($) {
  $(document).ready(function() {
    const logos = new Swiper('.logos', {
      speed: 1200,
      duration: 5000,
      grabCursor: true,
      loop: true,
      autoplay: true,
      breakpoints: {
        320: {
          slidesPerView: 2,
          spaceBetween: 40,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 40,
        },
        840: {
          slidesPerView: 4,
          spaceBetween: 150,
        },
      },
    });
  });
})(jQuery);

document.addEventListener('DOMContentLoaded', function() {
  if (typeof Swiper === 'undefined') {
console.warn('Swiper not found. Make sure Swiper JS is enqueued on this page.');
return;
  }

  new Swiper('.contact-swiper', {
loop: true,
slidesPerView: 1,
centeredSlides: true,
spaceBetween: 10,
navigation: {
  nextEl: '.contact-swiper .swiper-button-next',
  prevEl: '.contact-swiper .swiper-button-prev',
},
autoplay: {
  delay: 3500,
  disableOnInteraction: false,
},
breakpoints: {
  640: { slidesPerView: 1 },
  768: { slidesPerView: 1 }
}
  });
});