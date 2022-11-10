function switchShow() {
  const menu = document.getElementById("menu");
  if (menu.classList.contains("hidden")) {
    menu.classList.remove("hidden");
  } else {
    menu.classList.add("hidden");
  }
}

addEventListener("keydown", function (e) {
  if (e.ctrlKey && e.key == "k") {
    /* Do whatever */
    console.log(e);
    this.document.getElementById("search").focus();
    e.preventDefault();
  }
});

function setMode(mode) {
  const valueMode =document.getElementById("mode");
  console.log(valueMode.value)
  if(mode === valueMode.value) {
    valueMode.value = "all"
  } else {
    valueMode.value = mode
  }
  document.getElementById("form-search").submit()
}

function checkMode(){
  const valueMode =document.getElementById("mode");
  if(valueMode.value === "library") {
      document.getElementById("library").className = "package-active";
  } else if(valueMode.value === "template") {
      document.getElementById("template").className = "package-active";
  }
}
checkMode();