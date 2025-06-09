const CLASSNAME_LOADING = 'is-lazy-loading';
const CLASSNAME_LOADED = 'is-lazy-loaded';

const getRandomInt = (max) => {
  return Math.floor(Math.random() * max);
}

export const preloadImage = (element) => {
  if (element.dataset && element.dataset.src) {
    element.src = element.dataset.src;
  }

  if (element.dataset && element.dataset.srcset) {
    element.srcset = element.dataset.srcset
  }

  element.onload = () => {
    let delay = element.dataset.delay ? getRandomInt(4) * 100 : 0;

    setTimeout(() => {
      element.classList.remove(CLASSNAME_LOADING);
      element.classList.add(CLASSNAME_LOADED);
    }, delay);
  };
};

const imagesLoading = (() => {
  const config = {
    rootMargin: '50px 0px',
    threshold: 0.01
  };

  let observer;

  let onIntersection = (entries) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        observer.unobserve(entry.target);
        preloadImage(entry.target);
      }
    });
  };

  function init() {
    const images = window.document.querySelectorAll('.' + CLASSNAME_LOADING);

    if (!('IntersectionObserver' in window)) {
      Array.from(images).forEach(preloadImage);
    } else {
      observer = new IntersectionObserver(onIntersection, config);
      images.forEach(image => observer.observe(image));
    }
  }

  return {
    init,
  };
})();

export default imagesLoading;
