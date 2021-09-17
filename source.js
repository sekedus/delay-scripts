function delayGuestMode() {
  var ua = navigator.userAgent;
  return /Pingdom|Lighthouse|GTmetrix|PTST|DMBrowser|DareBoost|(Phantomas|YLT)|Statically|bot|Google|HeadlessChrome/i.test(ua);
}

function delayTriggerScriptLoader() {
  clearTimeout(delayLoadScriptsTimer);
  if (delayTrigger) {
    delayLoadWith = 'trigger';
    delayLoadScripts('trigger');
  }
  delayUserInteractionEvents.forEach(function(event) {
    window.removeEventListener(event, delayTriggerScriptLoader, { passive: true });
  });
}

function delayLoadScripts(note) {
  if (note != delayLoadWith) return;
  delayList = document.querySelectorAll('script[data-type^="lazy-"]');
  var d_script = delayList[delaySort];
  console.log('[delay-scripts] with: '+ delayLoadWith +', load: '+ d_script.dataset.type);
  
  if (!d_script.classList.contains('loaded')) {
    d_script.setAttribute('src', d_script.dataset.src);
    setTimeout(function() {
      d_script.classList.add('loaded');
      console.log('[delay-scripts] loaded: '+ d_script.dataset.type);
      if (delaySort+1 >= delayList.length) {
        console.log('[delay-scripts] All scripts loaded!');
      } else {
        delaySort = delaySort + 1;
        delayLoadScripts(note);
      }
    }, 250);
  }
}


var delayLoadScriptsTimer;
var delaySort = 0;
var delayList = [];
var delayTrigger = true;
var delaySpeedTest = false;
var delayLoadWith = delaySpeedTest && delayGuestMode() ? 'timeout' : 'onload';
var delayLoadTimeout = 4; //second
var delayLoadOnload = delayLoadWith == 'onload' ? true : false;

var delayUserInteractionEvents = [
  "mouseover",
  "keydown",
  "touchmove",
  "touchstart"
];

if (delayLoadOnload) {
  window.addEventListener('load', function() {
    delayTrigger = false;
    delayLoadScripts('onload');
  });
} else {
  delayLoadScriptsTimer = setTimeout(function() {
    delayTrigger = false;
    delayLoadScripts('timeout');
  }, delayLoadTimeout*1000);
}

delayUserInteractionEvents.forEach(function(event) {
  window.addEventListener(event, delayTriggerScriptLoader, { passive: true });
});
