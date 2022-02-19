window._ = require("lodash");
import "bootstrap";
import { Toast } from "bootstrap";

const toastMessage = document.getElementById("toastMessage");
if (toastMessage) {
    const toast = new Toast(toastMessage);
    toast.show();
}
