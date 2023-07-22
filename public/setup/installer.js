import generateStructure from './DomRenderer.js';

const routes = {
  '/step1': {
    render: renderStep1,
    onSubmit: onSubmitStep1
  },
  '/step2': {
    render: renderStep2,
    onSubmit: onSubmitStep2
  },
  '/step3': {
    render: renderStep3,
    onSubmit: onSubmitStep3
  },
  '/step4': {
    render: renderStep4
  }
};

function startInstallation() {
  const currentPath = window.location.pathname;

  if (routes.hasOwnProperty(currentPath)) {
    routes[currentPath].render();
  } else {
    navigateTo('/step1');
  }
}

function navigateTo(path) {
  window.history.pushState({}, '', path);
  routes[path].render();
}

function renderStep1() {
  fetch('/api/installation/step1')
    .then(response => response.json())
    .then(formStructure => {
      const formElement = generateStructure(formStructure);
      formElement.addEventListener('submit', routes['/step1'].onSubmit);
      const appElement = document.getElementById('app');
      while (appElement.firstChild) {
        appElement.removeChild(appElement.firstChild);
      }
      appElement.appendChild(formElement);
    });
}

function onSubmitStep1(event) {
  event.preventDefault();

  navigateTo('/step2');
}

function renderStep2() {
  fetch('/api/installation/step2')
    .then(response => response.json())
    .then(formStructure => {
      const formElement = generateStructure(formStructure);
      formElement.addEventListener('submit', routes['/step2'].onSubmit);
      const appElement = document.getElementById('app');
      while (appElement.firstChild) {
        appElement.removeChild(appElement.firstChild);
      }
      appElement.appendChild(formElement);
    });
}

function onSubmitStep2(event) {
  event.preventDefault();

  const formData = new FormData(event.target);

  fetch('/api/installation/createDatabase', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(responseData => {
      if (responseData.success) {
        navigateTo('/step3');
      } else {
        let errors = responseData.errors;

        clearErrorMessages();

        displayErrorMessages(errors);
      }
    });
}

function renderStep3() {
  fetch('/api/installation/step3')
    .then(response => response.json())
    .then(formStructure => {
      const formElement = generateStructure(formStructure);
      formElement.addEventListener('submit', routes['/step3'].onSubmit);
      const appElement = document.getElementById('app');
      while (appElement.firstChild) {
        appElement.removeChild(appElement.firstChild);
      }
      appElement.appendChild(formElement);
    });
}

function onSubmitStep3(event) {
  event.preventDefault();

  const formData = new FormData(event.target);

  fetch('/api/installation/createUser', {
    method: 'POST',
    body: formData
  })
    .then(response => response.json())
    .then(responseData => {
      if (responseData.success) {
        navigateTo('/step4');
      } else {
        let errors = responseData.errors;

        clearErrorMessages();

        displayErrorMessages(errors);
      }
    });
}

function renderStep4() {
  document.getElementById('app').innerHTML = '';

  let element = document.createElement('p');
  element.textContent = 'Installation terminée !';
  element.className = 'container alert alert-success';
  document.querySelector('#app').appendChild(element);
}

function clearErrorMessages() {
  const formElement = document.querySelector('#app form');
  const errorElements = formElement.querySelectorAll('.form-error');
  
  errorElements.forEach(element => {
    element.remove();
  });
}

function displayErrorMessages(errors) {
  const formElement = document.querySelector('#app form');

  errors.forEach(error => {
    let errorElement = document.createElement('p');
    errorElement.textContent = error;
    errorElement.className = 'form-error alert alert-danger';
    formElement.appendChild(errorElement);
  });
}

window.addEventListener('popstate', startInstallation);

document.addEventListener('DOMContentLoaded', startInstallation);