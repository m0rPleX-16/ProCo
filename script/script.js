 // CALENDAR SCRIPT STARTS HERE

 const daysTag = document.querySelector(".days"),
 currentDate = document.querySelector(".current-date"),
 prevNextIcon = document.querySelectorAll(".icons span");

// getting new date, current year and month
let date = new Date(),
 currYear = date.getFullYear(),
 currMonth = date.getMonth();

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
 "August", "September", "October", "November", "December"
];

const renderCalendar = () => {
 let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
     lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
     lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
     lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
 let liTag = "";

 for (let i = firstDayofMonth; i > 0; i--) { // creating li of previous month last days
     liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
 }

 for (let i = 1; i <= lastDateofMonth; i++) { // creating li of all days of current month
     // adding active class to li if the current day, month, and year matched
     let isToday = i === date.getDate() && currMonth === new Date().getMonth() &&
         currYear === new Date().getFullYear() ? "active" : "";
     liTag += `<li class="${isToday}">${i}</li>`;
 }

 for (let i = lastDayofMonth; i < 6; i++) { // creating li of next month first days
     liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
 }
 currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
 daysTag.innerHTML = liTag;
}
renderCalendar();

prevNextIcon.forEach(icon => { // getting prev and next icons
 icon.addEventListener("click", () => { // adding click event on both icons
     // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
     currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

     if (currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
         // creating a new date of current year & month and pass it as date value
         date = new Date(currYear, currMonth, new Date().getDate());
         currYear = date.getFullYear(); // updating current year with new date year
         currMonth = date.getMonth(); // updating current month with new date month
     } else {
         date = new Date(); // pass the current date as date value
     }
     renderCalendar(); // calling renderCalendar function
 });
});

// CALENDAR SCRIPT ENDS HERE

//TO-DO LIST STARTS HERE

const inputBox = document.getElementById("input-box");
const listContainer = document.getElementById("list-container");

function addTask() {
 if (inputBox.value === '') {
     alert("Write down a task.");
 } else {
     let li = document.createElement("li");
     li.innerHTML = inputBox.value;
     listContainer.appendChild(li);

     // for end of list
     let span = document.createElement("span");
     span.innerHTML = "\u00d7";
     li.appendChild(span);
 }
 inputBox.value = "";
 saveData();
}

listContainer.addEventListener("click", function(e) {
 if (e.target.tagName === "LI") {
     e.target.classList.toggle("checked");
     saveData();
 } else if (e.target.tagName === "SPAN") {
     e.target.parentElement.remove();
     saveData();
 }
}, false);

// to save list

function saveData() {
 localStorage.setItem("data", listContainer.innerHTML); //data is stored in browser with name of data. 
}

// to get data
function showTask() {
 listContainer.innerHTML = localStorage.getItem("data");
}
showTask();

// TO-DO LIST ENDS HERE

document.addEventListener("DOMContentLoaded", function() {
 var alertMessage = document.querySelector('.alert-message');
 alertMessage.style.display = 'block';
 setTimeout(function() {
     alertMessage.style.display = 'none';
 }, 3000);
});

document.addEventListener("DOMContentLoaded", function() {
 var alertMessage = document.querySelector('.alert-message');

 // Check if the message has already been displayed
 if (!localStorage.getItem('alertDisplayed')) {
     // If not, display the alert message
     alertMessage.style.display = 'block';

     // Set a flag in localStorage to indicate that the message has been displayed
     localStorage.setItem('alertDisplayed', 'true');

     // Hide the alert message after 3 seconds
     setTimeout(function() {
         alertMessage.style.display = 'none';
     }, 3000);
 }
});