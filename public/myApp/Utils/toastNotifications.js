// const button = document.getElementById("button");
const toast = document.getElementById("toasts");

const messages = [
  "Notificación Informativa",
  "Notificación Error",
  "Notificación Exitosa",
  "Notificación Advertencia"
];

const types = ["info", "success", "error", "warning"];

// button.addEventListener("click", () => createToast());

function createToast(message = null, type = null) {
  let properties;

  const notif = document.createElement("div");
  const notifIcon = document.createElement("span");
  const notificationType = type ? type : getRandomType();

  properties = setProperties(notificationType);

  notif.classList.add("toast");
  notif.classList.add(notificationType);

  notifIcon.classList.add(properties[0]);
  notifIcon.classList.add(properties[1]);
  
  notif.innerText = message;

  toast.appendChild(notif);
  notif.append(notifIcon);

  setTimeout(() => {
    notif.remove();
  }, 5000);
}

function setProperties(notificationType) {
  let propertyList;

  switch (notificationType) {
    case "info":
      propertyList = ["fas", "fa-info-circle", 0];
      break;
    case "error":
      propertyList = ["fas", "fa-exclamation-circle", 1];
      break;
    case "success":
      propertyList = ["fas", "fa-check-circle", 2];
      break;
    case "warning":
      propertyList = ["fas", "fa-exclamation-triangle", 3];
      break;
  }

  return propertyList;
}

// function getRandomType() {
//   return types[Math.floor(Math.random() * types.length)];
// }