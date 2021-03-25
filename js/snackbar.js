const textColors = {
  info: "#FFFFFF",
  success: "#FFFFFF",
  warning: "#000",
  error: "#FFFFFF",
};

const backgroundColors = {
  info: "#08f",
  success: "#080",
  warning: "orange",
  error: "crimson",
};

function snackbar(text, severity = "info") {
  Snackbar.show({
    text,
    pos: "bottom-center",
    actionText: "Chiudi",
    textColor: textColors[severity],
    backgroundColor: backgroundColors[severity],
  });
}
