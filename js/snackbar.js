const textColors = {
  info: "#FFFFFF",
  success: "#FFFFFF",
  warning: "#323232",
  error: "#FFFFFF",
};

const backgroundColors = {
  info: "#08f",
  success: "#080",
  warning: "#ffa500",
  error: "#dc143c",
};

const actionTextColors = {
  info: "#048",
  success: "#040",
  warning: "#7f5200",
  error: "#6e0A1e",
};

function snackbar(text, severity = "info") {
  Snackbar.show({
    text,
    pos: "bottom-center",
    actionText: "Chiudi",
    textColor: textColors[severity] || "#FFFFFF",
    backgroundColor: backgroundColors[severity] || "#323232",
    actionTextColor: actionTextColors[severity] || "#4CAF50",
  });
}
