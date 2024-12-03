const API_URL = 'https://provinces.open-api.vn/api';

async function fetchProvinces() {
    try {
        const response = await fetch(`${API_URL}/p/`);
        const provinces = await response.json();
        const provinceSelect = document.getElementById('province');
        
        provinces.forEach(province => {
            const option = new Option(province.name, province.code);
            provinceSelect.add(option);
        });
    } catch (error) {
        console.error('Error fetching provinces:', error);
    }
}

async function fetchDistricts(provinceCode) {
    try {
        const response = await fetch(`${API_URL}/p/${provinceCode}?depth=2`);
        const data = await response.json();
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');
        
        // Reset districts and wards
        districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>';
        wardSelect.innerHTML = '<option value="">Chọn Xã/Phường/Thị trấn</option>';
        
        data.districts.forEach(district => {
            const option = new Option(district.name, district.code);
            districtSelect.add(option);
        });
        
        districtSelect.disabled = false;
        wardSelect.disabled = true;
    } catch (error) {
        console.error('Error fetching districts:', error);
    }
}

async function fetchWards(districtCode) {
    try {
        const response = await fetch(`${API_URL}/d/${districtCode}?depth=2`);
        const data = await response.json();
        const wardSelect = document.getElementById('ward');
        
        // Reset wards
        wardSelect.innerHTML = '<option value="">Chọn Xã/Phường/Thị trấn</option>';
        
        data.wards.forEach(ward => {
            const option = new Option(ward.name, ward.code);
            wardSelect.add(option);
        });
        
        wardSelect.disabled = false;
    } catch (error) {
        console.error('Error fetching wards:', error);
    }
}

// Event Listeners
document.getElementById('province').addEventListener('change', function() {
    const provinceCode = this.value;
    if (provinceCode) {
        fetchDistricts(provinceCode);
    }
});

document.getElementById('district').addEventListener('change', function() {
    const districtCode = this.value;
    if (districtCode) {
        fetchWards(districtCode);
    }
});

// Load provinces when page loads
document.addEventListener('DOMContentLoaded', fetchProvinces);
