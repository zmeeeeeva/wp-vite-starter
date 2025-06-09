export default function(el, cb, t = 0.2) {
  let config = {
    root: null,
    rootMargin: '0px',
    threshold: t
  };

  let observer = new IntersectionObserver(callback, config);

  function callback(changes, observer) {
    changes.forEach(cb);
  }

  observer.observe(el);
  return observer;
}

