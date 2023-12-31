function openDialog(openid) {
    reopenDialog();
    hideDialog();
    document.getElementById("dialogue").style.display =
        document.getElementById(openid).style.display =
        document.getElementById("hide-screen").style.display = "block";
}

function hideDialog() {
    for (const mod of document.getElementById("dialogue").getElementsByTagName("form")) {
        mod.style.display = "none";
    }
    document.getElementById("dialogue").style.display =
        document.getElementById("hide-screen").style.display = "none";
}

function smallDialog() {
    const obj = document.getElementById("dialogue");
    obj.style.width = "60px";
    obj.style.height = "50px";
    obj.style.padding = "0";
    obj.style.margin = "0";
    obj.style.top = "calc(100% - 65px)";
    obj.style.left = "calc(50% - 60px)";
    obj.getElementsByTagName("button")[0].style.display =
        document.getElementById("hide-screen").style.display = "none";
    obj.getElementsByTagName("button")[1].innerText = "↑";
    obj.getElementsByTagName("button")[1].onclick = () => {
        reopenDialog();
    }
}

function reopenDialog() {
    const obj = document.getElementById("dialogue");
    obj.style.width = "70%";
    obj.style.height = "fit-content";
    obj.style.margin = "auto";
    obj.style.top = "0";
    obj.style.padding = "15px";
    obj.style.left = "0";
    obj.getElementsByTagName("button")[0].style.display =
        document.getElementById("hide-screen").style.display = "initial";
    obj.getElementsByTagName("button")[1].innerText = "-";
    obj.getElementsByTagName("button")[1].onclick = () => {
        smallDialog();
    }
}