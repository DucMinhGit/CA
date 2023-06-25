var cities = document.getElementById('city');
var districts = document.getElementById('district');
var wards = document.getElementById('ward');
var token = document.getElementById('token');

var chooseLocation = document.getElementsByClassName('choose_location');

for (let i = 0; i < chooseLocation.length; i++) 
{
    chooseLocation[i].onchange = function () {
        var data = { location_code: this.value, location_name: this.id, _token: token.value };
        var result = '';

        if (this.id === 'city') {
            result = 'district';
        }
        else if (this.id === 'district') {
            result = 'ward';
        }

        location_fetch('http://localhost/tb/ca/location.php', data, result);

        if (this.id === 'city') {
            wards.innerHTML = '<option value="">--- Choose a ward ---</option>';
        }
    }
}

auto_load_location(cities, districts, token);

auto_load_location(districts, wards, token);

// used to auto load the list of child locations if the parent location is already selected
// example: if cities(parent location) is selected when district(child location) will auto load list
function auto_load_location(parent, child, token) 
{
    if (parent.value !== '' && child.value === '') 
    {
        let data = { location_code: parent.value, location_name: parent.id, _token: token.value };
        let result = child.id;

        location_fetch('http://localhost/tb/ca/location.php', data, result);
    }
}

function location_fetch(url, data, result) 
{
    fetch(url, {
        method: 'POST',
        body: JSON.stringify(data),
    })
    .then(function (response) {
        if (response.status === 422) {
            return Promise.reject(response.json());
        }
        return response.text();
    })
    .then(function (data) {
        document.getElementById(result).innerHTML = data;
    });
}