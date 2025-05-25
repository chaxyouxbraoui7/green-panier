function generateBubbles(selector = '.bubble-effect') {
  const container = document.querySelector(selector);
   if (!container) return;
   container.innerHTML = '';
   for (let i = 0; i < 22; i++) {
       const bubble = document.createElement('div');
       bubble.className = 'bubble';
       bubble.style.setProperty('--size', `${1 + Math.random() * 3}rem`);
       bubble.style.setProperty('--position', `${Math.random() * 100}%`);
       bubble.style.setProperty('--time', `${3 + Math.random() * 4}s`);
       bubble.style.setProperty('--delay', `${Math.random() * 5}s`);
       bubble.style.setProperty('--distance', `${75 + Math.random() * 25}%`);
       container.appendChild(bubble);
   }
}

function toastIt() {
  const options = {
    day: 'numeric',
    month: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  };

  let timeToastContainer = document.getElementById("time-toast-container");
  if (!timeToastContainer) {
    timeToastContainer = document.createElement("div");
    timeToastContainer.id = "time-toast-container";
    timeToastContainer.style.position = "fixed";
    timeToastContainer.style.top = "25px";
    timeToastContainer.style.right = "25px";
    timeToastContainer.style.zIndex = "9999";
    document.body.appendChild(timeToastContainer);
  }

  const toast = document.createElement("div");
  toast.className = "time-toast";
  toast.innerText = `Current Time is: ${new Date().toLocaleString(undefined, options)}`;
  timeToastContainer.appendChild(toast);
  toast.style.display = "block";

  setTimeout(() => {toast.style.animation = "fadeOut 0.25s forwards"; setTimeout(() => toast.remove(), 7500);}, 2500);
}

window.addEventListener("DOMContentLoaded", () => {
  generateBubbles();
  toastIt();
  setInterval(toastIt, 7 * 60 * 1000);

});