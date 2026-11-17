// ==========================
// Student Election System
// JavaScript
// ==========================

// Welcome Message

console.log("Student Election System Loaded");

// Confirm Vote

function confirmVote() {
  return confirm("Are you sure you want to submit your vote?");
}

// Logout Confirmation

function logout() {
  return confirm("Do you really want to logout?");
}

// Password Show/Hide

function togglePassword(id) {
  let x = document.getElementById(id);

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
