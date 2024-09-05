document.addEventListener("DOMContentLoaded", function () {
  var startDateInput = document.getElementById("startDate");
  var endDateInput = document.getElementById("endDate");

  startDateInput.addEventListener("change", function () {
    var startDate = new Date(this.value);
    var minEndDate = new Date(startDate);
    minEndDate.setDate(startDate.getDate() + 1);
    var minEndDateString = minEndDate.toISOString().split("T")[0];
    endDateInput.removeAttribute("disabled");
    endDateInput.setAttribute("min", minEndDateString);
  });

  var today = new Date().toISOString().split("T")[0];
  startDateInput.setAttribute("min", today);
  startDateInput.setAttribute(
    "max",
    new Date(new Date().setMonth(new Date().getMonth() + 1))
      .toISOString()
      .split("T")[0]
  );
});

function pilihpaket(text, id) {
  var pilihpaket = document.querySelector(".pilihpaket");
  var hiddenInput = document.getElementById("pilihpaket");
  var apilihpaket = document.querySelector(".apilihpaket");
  apilihpaket.textContent = "Ganti Paket";
  pilihpaket.textContent = text;
  hiddenInput.value = id;
  hitungTotalHargaRealtime();
}

function pilihLayanan() {
  var pilihlayanan = document.querySelector(".pilihlayanan");
  var hiddenInputContainer = document.getElementById("pilihlayananinput");
  hiddenInputContainer.innerHTML = "";
  var checkboxes = document.querySelectorAll(
    '#layananPilihan input[type="checkbox"]:checked'
  );
  var layananText = [];
  checkboxes.forEach(function (checkbox) {
    var hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "pilihlayanan[]";
    hiddenInput.value = checkbox.value;
    hiddenInput.required = true;
    hiddenInputContainer.appendChild(hiddenInput);
    layananText.push(checkbox.dataset.text);
  });
  pilihlayanan.textContent = layananText.length;
  hitungTotalHargaRealtime();
}

function updateBookingDetails() {
  let paket = document.getElementById("pilihpaket").value;
  let jumlahOrang = document.getElementById("numberOfPeople").value;
  let startDate = document.getElementById("startDate").value;
  let endDate = document.getElementById("endDate").value;
  let totalHari =
    (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24) + 1;
  let layananTambahan = document.querySelectorAll(
    '#layananPilihan input[type="checkbox"]:checked'
  );
  let detailBooking = "";

  if (jumlahOrang) {
    detailBooking += `<li class="list-group-item"> Jumlah Orang - <strong>${jumlahOrang} Orang</strong></li>`;
  }

  if (startDate && endDate) {
    let options = {
      day: "2-digit",
      month: "long",
      year: "numeric",
    };
    let startDateFormatted = new Date(startDate).toLocaleDateString(
      "id-ID",
      options
    );
    let endDateFormatted = new Date(endDate).toLocaleDateString(
      "id-ID",
      options
    );
    detailBooking += `<li class="list-group-item"> Tanggal Liburan - <strong>${startDateFormatted}</strong> s/d <strong>${endDateFormatted}</strong></li>`;
  }

  if (paket) {
    let paketText = paketArray.find((item) => item.id === paket).text;
    detailBooking += `<li class="list-group-item"> ${paketText} - <strong>${
      isNaN(totalHari) ? 0 : totalHari
    } Hari</strong></li>`;
  }

  layananTambahan.forEach((layanan) => {
    let layananText = layananArray.find(
      (item) => item.id === layanan.value
    ).text;
    detailBooking += `<li class="list-group-item"> Layanan ${layananText} - <strong>${
      isNaN(totalHari) ? 0 : totalHari
    } Hari</strong></li>`;
  });

  document.getElementById("detailBooking").innerHTML = detailBooking;
}

function hitungTotalHargaRealtime() {
  var totalHarga = 0;
  var paketDipilih = document.getElementById("pilihpaket").value;
  var jumlahOrang =
    parseInt(
      document.getElementById("numberOfPeople").value.replace(",", "")
    ) || 1;
  if (paketDipilih && hargaData.paket[paketDipilih]) {
    totalHarga += hargaData.paket[paketDipilih] * jumlahOrang;
  }

  var layananCheckboxes = document.querySelectorAll(
    '#layananPilihan input[type="checkbox"]:checked'
  );
  layananCheckboxes.forEach(function (checkbox) {
    var layananId = checkbox.value;
    if (layananId && hargaData.layanan[layananId]) {
      totalHarga += hargaData.layanan[layananId];
    }
  });

  var startDate = new Date(document.getElementById("startDate").value);
  var endDate = new Date(document.getElementById("endDate").value);
  var totalHari = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;
  totalHarga *= totalHari;

  if (!isNaN(totalHarga)) {
    document.getElementById("totalHarga").value = new Intl.NumberFormat(
      "id-ID"
    ).format(totalHarga);
  } else {
    document.getElementById("totalHarga").value = "0";
  }
  updateBookingDetails();
}
