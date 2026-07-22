
function previewPrice(price) {
  const premiumInput = document.getElementById("premium_v");
  if (!premiumInput) {
    return;
  }
  premiumInput.value = String(price).trim();
}

const OFFLINE_DB_NAME = "newSystemOfflineDb";
const OFFLINE_STORE_NAME = "customerQueue";

function getInputData() {
  return {
    customerName: document.getElementById("customerName")?.value.trim() || "",
    vehicleNumber: document.getElementById("vehicleNumber")?.value.trim() || "",
    chassisNumber: document.getElementById("chassisNumber")?.value.trim() || "",
    contactNumber: document.getElementById("contactNumber")?.value.trim() || "",
    vehicleType: document.getElementById("vehicleType")?.value || "",
    nic: document.getElementById("nic")?.value.trim() || "",
    premium: document.getElementById("premium_v")?.value.trim() || "",
    uploadCr: document.getElementById("uploadCr")?.files?.[0] || null,
    uploadNic: document.getElementById("uploadNic")?.files?.[0] || null,
    uploadExpiredCard: document.getElementById("uploadExpiredCard")?.files?.[0] || null
  };
}

function validateInputs(data) {
  const errors = {};

  if (!data.customerName) {
    errors.customerName = "Customer name is required.";
  }

  if (!data.vehicleNumber) {
    errors.vehicleNumber = "Vehicle number is required.";
  }

  if (!data.chassisNumber) {
    errors.chassisNumber = "Chassis number is required.";
  }

  if (!data.contactNumber) {
    errors.contactNumber = "Contact number is required.";
  } else if (!/^[0-9+\-\s]{9,15}$/.test(data.contactNumber)) {
    errors.contactNumber = "Contact number format is invalid.";
  }

  if (!data.vehicleType) {
    errors.vehicleType = "Vehicle type is required.";
  }

  if (!data.nic) {
    errors.nic = "NIC is required.";
  } else if (!/^([0-9]{9}[vVxX]|[0-9]{12})$/.test(data.nic)) {
    errors.nic = "NIC must be 9 digits + V/X or 12 digits.";
  }

  if (!data.premium) {
    errors.premium = "Premium is required.";
  } else if (!/^[0-9]+(?:\.[0-9]{1,2})?$/.test(data.premium)) {
    errors.premium = "Premium must be a valid amount.";
  }

  if (!data.uploadCr) {
    errors.uploadCr = "CR document is required.";
  }

  if (!data.uploadNic) {
    errors.uploadNic = "NIC document is required.";
  }

  return {
    isValid: Object.keys(errors).length === 0,
    errors
  };
}

function setValidationState(errors) {
  const fields = {
    customerName: document.getElementById("customerName"),
    vehicleNumber: document.getElementById("vehicleNumber"),
    chassisNumber: document.getElementById("chassisNumber"),
    contactNumber: document.getElementById("contactNumber"),
    vehicleType: document.getElementById("vehicleType"),
    nic: document.getElementById("nic"),
    premium: document.getElementById("premium_v"),
    uploadCr: document.getElementById("uploadCr"),
    uploadNic: document.getElementById("uploadNic"),
    uploadExpiredCard: document.getElementById("uploadExpiredCard")
  };

  Object.keys(fields).forEach(function(key) {
    const element = fields[key];
    if (!element) {
      return;
    }

    const hasError = Object.prototype.hasOwnProperty.call(errors, key);
    element.classList.toggle("is-invalid", hasError);
    element.classList.toggle("is-valid", !hasError && element.value !== "");
    element.setCustomValidity(hasError ? errors[key] : "");
  });
}

function registerServiceWorker() {
  if (!("serviceWorker" in navigator)) {
    return;
  }

  navigator.serviceWorker.register("service-worker.js").catch(function() {
    // Silent fail: app continues to work without SW.
  });
}

function openOfflineDb() {
  return new Promise(function(resolve, reject) {
    if (!("indexedDB" in window)) {
      reject(new Error("IndexedDB is not supported in this browser."));
      return;
    }

    const request = indexedDB.open(OFFLINE_DB_NAME, 1);

    request.onupgradeneeded = function(event) {
      const db = event.target.result;
      if (!db.objectStoreNames.contains(OFFLINE_STORE_NAME)) {
        db.createObjectStore(OFFLINE_STORE_NAME, {
          keyPath: "id",
          autoIncrement: true
        });
      }
    };

    request.onsuccess = function(event) {
      resolve(event.target.result);
    };

    request.onerror = function() {
      reject(new Error("Failed to open offline database."));
    };
  });
}

function addToOfflineQueue(payload) {
  return openOfflineDb().then(function(db) {
    return new Promise(function(resolve, reject) {
      const tx = db.transaction([OFFLINE_STORE_NAME], "readwrite");
      const store = tx.objectStore(OFFLINE_STORE_NAME);
      const request = store.add(payload);

      request.onsuccess = function() {
        resolve();
      };

      request.onerror = function() {
        reject(new Error("Failed to queue offline submission."));
      };
    });
  });
}

function getQueuedSubmissions() {
  return openOfflineDb().then(function(db) {
    return new Promise(function(resolve, reject) {
      const tx = db.transaction([OFFLINE_STORE_NAME], "readonly");
      const store = tx.objectStore(OFFLINE_STORE_NAME);
      const request = store.getAll();

      request.onsuccess = function() {
        resolve(request.result || []);
      };

      request.onerror = function() {
        reject(new Error("Failed to read offline queue."));
      };
    });
  });
}

function removeQueuedSubmission(id) {
  return openOfflineDb().then(function(db) {
    return new Promise(function(resolve, reject) {
      const tx = db.transaction([OFFLINE_STORE_NAME], "readwrite");
      const store = tx.objectStore(OFFLINE_STORE_NAME);
      const request = store.delete(id);

      request.onsuccess = function() {
        resolve();
      };

      request.onerror = function() {
        reject(new Error("Failed to update offline queue."));
      };
    });
  });
}

function getQueueCount() {
  return getQueuedSubmissions().then(function(items) {
    return items.length;
  }).catch(function() {
    return 0;
  });
}

function buildFormDataFromPayload(payload) {
  const formData = new FormData();
  formData.append("customerName", payload.customerName);
  formData.append("vehicleNumber", payload.vehicleNumber);
  formData.append("chassisNumber", payload.chassisNumber);
  formData.append("contactNumber", payload.contactNumber);
  formData.append("vehicleType", payload.vehicleType);
  formData.append("nic", payload.nic);
  formData.append("premium", payload.premium);
  formData.append("uploadCr", payload.uploadCr);
  formData.append("uploadNic", payload.uploadNic);

  if (payload.uploadExpiredCard) {
    formData.append("uploadExpiredCard", payload.uploadExpiredCard);
  }

  return formData;
}

function buildOfflinePayload(data) {
  return {
    createdAt: Date.now(),
    customerName: data.customerName,
    vehicleNumber: data.vehicleNumber,
    chassisNumber: data.chassisNumber,
    contactNumber: data.contactNumber,
    vehicleType: data.vehicleType,
    nic: data.nic,
    premium: data.premium,
    uploadCr: data.uploadCr,
    uploadNic: data.uploadNic,
    uploadExpiredCard: data.uploadExpiredCard
  };
}

function updateBillingPreview(selectElement) {
  const selectedOption = selectElement?.options?.[selectElement.selectedIndex] || null;

  const nameEl = document.getElementById("billName");
  const vehicleEl = document.getElementById("billVehicle");
  const typeEl = document.getElementById("billType");
  const contactEl = document.getElementById("billContact");
  const pointEl = document.getElementById("billPoint");
  const issuedEl = document.getElementById("billIssued");
  const expireEl = document.getElementById("billExpire");
  const addButton = document.getElementById("addToBillingBtn");

  if (!selectedOption || !selectedOption.value) {
    if (nameEl) nameEl.textContent = "-";
    if (vehicleEl) vehicleEl.textContent = "-";
    if (typeEl) typeEl.textContent = "-";
    if (contactEl) contactEl.textContent = "-";
    if (pointEl) pointEl.textContent = "-";
    if (issuedEl) issuedEl.textContent = "-";
    if (expireEl) expireEl.textContent = "-";
    if (addButton) addButton.disabled = true;
    return;
  }

  if (nameEl) nameEl.textContent = selectedOption.dataset.cname || "-";
  if (vehicleEl) vehicleEl.textContent = selectedOption.dataset.vno || "-";
  if (typeEl) typeEl.textContent = selectedOption.dataset.vtype || "-";
  if (contactEl) contactEl.textContent = selectedOption.dataset.contact || "-";
  if (pointEl) pointEl.textContent = selectedOption.dataset.point || "-";
  if (issuedEl) issuedEl.textContent = selectedOption.dataset.issued || "-";
  if (expireEl) expireEl.textContent = selectedOption.dataset.expire || "-";
  if (addButton) addButton.disabled = false;
}

async function addCustomerToBillingHistory(customerId) {
  const response = await fetch("addBillingHistoryProcess.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: new URLSearchParams({
      customerId: String(customerId)
    })
  });

  let result = {};
  try {
    result = await response.json();
  } catch (error) {
    throw new Error("Invalid server response.");
  }

  if (!response.ok || !result.success) {
    throw new Error(result.message || "Failed to add billing history.");
  }

  return result;
}

async function submitOnlineFromPayload(payload) {
  const response = await fetch("../storeCustomerdataProcess.php", {
    method: "POST",
    body: buildFormDataFromPayload(payload)
  });

  const result = await response.json();
  if (!response.ok || !result.success) {
    throw new Error(result.message || "Failed to submit customer data.");
  }

  return result;
}

function ensureOfflineStatusBar() {
  let bar = document.getElementById("offlineStatusBar");
  if (bar) {
    return bar;
  }

  bar = document.createElement("div");
  bar.id = "offlineStatusBar";
  bar.style.position = "fixed";
  bar.style.left = "12px";
  bar.style.right = "12px";
  bar.style.bottom = "12px";
  bar.style.zIndex = "1060";
  bar.style.padding = "10px 12px";
  bar.style.borderRadius = "10px";
  bar.style.fontSize = "0.9rem";
  bar.style.fontWeight = "600";
  bar.style.border = "1px solid #2f3d4e";
  bar.style.background = "#131a24";
  bar.style.color = "#d9e6f2";
  bar.style.boxShadow = "0 10px 28px rgba(0,0,0,0.35)";
  bar.style.display = "none";
  document.body.appendChild(bar);

  return bar;
}

async function updateOfflineStatusBar() {
  const bar = ensureOfflineStatusBar();
  const queued = await getQueueCount();

  if (!navigator.onLine) {
    bar.style.display = "block";
    bar.style.borderColor = "#7b5e1d";
    bar.style.background = "#2a210f";
    bar.style.color = "#ffd98a";
    bar.textContent = queued > 0
      ? "Offline mode: " + queued + " customer request(s) waiting to sync."
      : "Offline mode: new customer submissions will be queued and synced automatically.";
    return;
  }

  if (queued > 0) {
    bar.style.display = "block";
    bar.style.borderColor = "#2d5c72";
    bar.style.background = "#12222e";
    bar.style.color = "#8de9ff";
    bar.textContent = "Online: syncing " + queued + " queued request(s)...";
    return;
  }

  bar.style.display = "none";
}

let isSyncingQueue = false;

async function syncOfflineQueue() {
  if (!navigator.onLine || isSyncingQueue) {
    return;
  }

  isSyncingQueue = true;
  try {
    await updateOfflineStatusBar();
    const items = await getQueuedSubmissions();

    for (let i = 0; i < items.length; i += 1) {
      const item = items[i];
      try {
        await submitOnlineFromPayload(item);
        await removeQueuedSubmission(item.id);
      } catch (error) {
        // Keep failed item in queue for retry.
      }
    }

    await updateOfflineStatusBar();
  } finally {
    isSyncingQueue = false;
  }
}

document.addEventListener("DOMContentLoaded", function() {
  registerServiceWorker();

  const form = document.getElementById("newCustomerForm");
  const submitButton = document.getElementById("submitBtn");
  if (!form) {
    return;
  }

  updateOfflineStatusBar();
  syncOfflineQueue();

  window.addEventListener("online", function() {
    updateOfflineStatusBar();
    syncOfflineQueue();
  });

  window.addEventListener("offline", function() {
    updateOfflineStatusBar();
  });

  form.addEventListener("submit", async function(event) {
    event.preventDefault();
    event.stopPropagation();

    const data = getInputData();
    const validation = validateInputs(data);

    setValidationState(validation.errors);

    if (!validation.isValid) {
      form.reportValidity();
      return;
    }

    const originalButtonText = submitButton ? submitButton.textContent : "Submit";

    if (submitButton) {
      submitButton.disabled = true;
      submitButton.textContent = navigator.onLine ? "Submitting..." : "Saving Offline...";
    }

    try {
      if (!navigator.onLine) {
        await addToOfflineQueue(buildOfflinePayload(data));
        showSuccessToast("You are offline. Customer request saved and will sync automatically.");
        form.reset();
        setValidationState({});
        await updateOfflineStatusBar();
      } else {
        const result = await submitOnlineFromPayload(data);
        showSuccessToast(result.message || "Customer data submitted successfully.");
        form.reset();
        setValidationState({});

        setTimeout(function() {
          window.location.reload();
        }, 1200);
      }
    } catch (error) {
      alert(error.message || "An unexpected error occurred while submitting data.");
    } finally {
      if (submitButton) {
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
      }
    }
  });

  const billingSelect = document.getElementById("billingCustomerSelect");
  const addBillingButton = document.getElementById("addToBillingBtn");

  if (billingSelect) {
    updateBillingPreview(billingSelect);

    billingSelect.addEventListener("change", function() {
      updateBillingPreview(billingSelect);
    });
  }

  if (addBillingButton && billingSelect && addBillingButton.dataset.mode === "single") {
    addBillingButton.addEventListener("click", async function() {
      const selectedCustomerId = billingSelect.value;
      if (!selectedCustomerId) {
        alert("Please select a pending customer.");
        return;
      }

      const originalButtonText = addBillingButton.textContent;
      addBillingButton.disabled = true;
      addBillingButton.textContent = "Adding...";

      try {
        const result = await addCustomerToBillingHistory(selectedCustomerId);
        showSuccessToast(result.message || "Customer added to billing history.");

        setTimeout(function() {
          window.location.reload();
        }, 1000);
      } catch (error) {
        alert(error.message || "An unexpected error occurred.");
        addBillingButton.disabled = false;
        addBillingButton.textContent = originalButtonText;
      }
    });
  }
});

