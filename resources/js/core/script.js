
document.addEventListener('DOMContentLoaded', (event) => {
    const jenisLayanan = document.getElementById('jenisLayanan');
    const uangCustomer = document.getElementById('uangCustomer');
    const totalHargaElem = document.getElementById('totalHarga');
    const kembalianElem = document.getElementById('kembalian');
    const totalHargaHidden = document.getElementById('totalHargaHidden');
    function updateTotal() {
      const selectedOption = jenisLayanan.options[jenisLayanan.selectedIndex];
      const hargaLayanan = parseFloat(selectedOption.getAttribute('data-price')) || 0;
      const uangCustomerValue = parseFloat(uangCustomer.value) || 0;
      const totalHarga = hargaLayanan;
      let kembalian = uangCustomerValue - totalHarga;

      totalHargaElem.textContent = totalHarga.toLocaleString('id-ID');
      totalHargaHidden.value = totalHarga;
      if (kembalian < 0) {
        kembalianElem.textContent = "Uang tidak cukup";
        kembalianElem.style.color = "red";
      } else {
        kembalianElem.textContent = kembalian.toLocaleString('id-ID');
        kembalianElem.style.color = "black";
      }
    }

    jenisLayanan.addEventListener('change', updateTotal);
    uangCustomer.addEventListener('input', updateTotal);
});

