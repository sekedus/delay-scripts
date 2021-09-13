function delayTriggerScriptLoader() {
  clearTimeout(delayLoadScriptsTimer);
  delayLoadScripts('timeout');
  delayUserInteractionEvents.forEach(function(event) {
    window.removeEventListener(event, delayTriggerScriptLoader, { passive: true });
  });
}

function delayLoadScripts(note) {
  delayList = document.querySelectorAll('script[data-type^="lazy-"]');
  if (delaySort >= delayList.length || note != delayLoadWith) return;
  console.log('delayLoadScripts: '+ delayList[delaySort].getAttribute('data-type'));
  delayList[delaySort].setAttribute('src', delayList[delaySort].getAttribute('data-src'));
  setTimeout(function() {
    delayList[delaySort].classList.add('loaded');
    delaySort = delaySort + 1;
    delayLoadScripts(note);
  }, 500);
}


var delaySort = 0;
var delayList = [];
const delaySpeedTest = false;
const delayLoadWith = delaySpeedTest ? 'timeout' : 'onload';
const delayLoadTimeout = 4; //second
const delayLoadOnload = delayLoadWith == 'onload' ? true : false;
console.log('delayLoadWith: '+ delayLoadWith);

const delayUserInteractionEvents = [
  "mouseover",
  "keydown",
  "touchmove",
  "touchstart"
];

const delayLoadScriptsTimer = setTimeout(function() {
  delayLoadScripts('timeout');
}, delayLoadTimeout*1000);

if (delayLoadOnload) {
  clearTimeout(delayLoadScriptsTimer);
  window.addEventListener('load', function() {
    delayLoadScripts('onload');
  });
} else {
  delayUserInteractionEvents.forEach(function(event) {
    window.addEventListener(event, delayTriggerScriptLoader, { passive: true });
  });
}
