// components/contact-form.js
function initContactForm(selector) {
  const form = document.querySelector(selector);
  if (!form) return;

  const status = form.querySelector(".contacto-ncb__status");
  const btn = form.querySelector('[type="submit"]');

  function setStatus(message, type = "") {
    status.textContent = message;
    status.className =
      "contacto-ncb__status mt-3" + (type ? ` text-${type}` : "");
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    form.classList.add("was-validated");
    if (!form.checkValidity()) return;

    btn.disabled = true;
    setStatus("Enviando...");

    try {
      const res = await fetch(form.getAttribute("action"), {
        method: "POST",
        body: new FormData(form),
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });

      let data = {};
      try {
        data = await res.json();
      } catch (_) {
        throw new Error("No pudimos enviar tu mensaje. Inténtalo nuevamente.");
      }

      if (!res.ok || !data.ok) {
        // Marca los campos que el servidor rechazó
        Object.keys(data.errors || {}).forEach((name) => {
          form.querySelector(`[name="${name}"]`)?.classList.add("is-invalid");
        });
        throw new Error(data.message || "Error al enviar");
      }

      form.reset();
      form.classList.remove("was-validated");
      setStatus(data.message, "success");
    } catch (err) {
      setStatus(err.message, "danger");
    } finally {
      btn.disabled = false;
    }
  });

  form.addEventListener("input", (e) =>
    e.target.classList.remove("is-invalid"),
  );
}
