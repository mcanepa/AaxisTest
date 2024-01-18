const API_URL = "http://127.0.0.1:8000/api/";

const register = document.getElementById("register");
const login = document.getElementById("login");
const token = document.getElementById("token");
const products_list = document.getElementById("products_list");
const do_get = document.getElementById("do_get");
const do_post = document.getElementById("do_post");
const do_put = document.getElementById("do_put");

register.addEventListener("submit", async function(e)
{
	e.preventDefault();

	const formData = new FormData(register);

	const body = JSON.stringify(Object.fromEntries(formData));

	const registerResponse = await fetch(API_URL + "registration", {
		method: "POST",
		body
	});

	const response = await registerResponse.json();

	if(registerResponse.ok)
	{
		alert("Usuario creado!!");
	}
	else
	{
		alert(response.message);
	}


	return false;
});

login.addEventListener("submit", async function(e)
{
	e.preventDefault();

	const formData = new FormData(login);

	const body = JSON.stringify(Object.fromEntries(formData));

	const loginResponse = await fetch(API_URL + "login_check", {
		method: "POST",
		body
	});

	const response = await loginResponse.json();

	if(loginResponse.ok)
	{
		token.value = response.token;
	}
	else
	{
		alert(response.message);
	}


	return false;
});

do_get.addEventListener("click", async function(e)
{
	const responseGet = await fetch(API_URL + "products", {
		headers: {
			"Content-type": "application/json",
			"Authorization": "Bearer " + token.value
		}
	});

	const response = await responseGet.json();

	if(responseGet.ok)
	{
		let tbody = products_list.querySelector("tbody");

		tbody.innerHTML = "";

		if(response.length)
		{
			for(let product of response)
			{
				let newRow = tbody.insertRow();
				let newCell_SKU = newRow.insertCell();
				let newCell_Name = newRow.insertCell();
				let textSKU = document.createTextNode(product.sku);
				let textName = document.createTextNode(product.name);

				newCell_SKU.appendChild(textSKU);
				newCell_Name.appendChild(textName);
			}
		}
		else
		{
			let newRow = tbody.insertRow();
			let newCell1 = newRow.insertCell();
			let newCell2 = newRow.insertCell();
			let text1 = document.createTextNode("No hay registros...");
			let text2 = document.createTextNode("");

			newCell1.appendChild(text1);
			newCell2.appendChild(text2);
		}
	}
	else
	{
		alert(response.message);
	}
});

do_post.addEventListener("submit", async function(e)
{
	e.preventDefault();

	const formData = new FormData(do_post);

	const data = Object.fromEntries(formData);

	const body = data.payload;

	const postResponse = await fetch(API_URL + "products", {
		headers: {
			"Content-type": "application/json",
			"Authorization": "Bearer " + token.value
		},
		method: "POST",
		body
	});

	const response = await postResponse.json();

	if(postResponse.ok)
	{
		if(response.items.length)
		{
			alert("Productos creados!");
		}

		if(response.errors.length)
		{
			let err_msg = "";

			for(let e of response.errors)
			{
				err_msg += e + "\n";
			}

			alert(err_msg);
		}
	}
	else
	{
		alert(response.message);
	}

	return false;
});

do_put.addEventListener("submit", async function(e)
{
	e.preventDefault();

	const formData = new FormData(do_put);

	const data = Object.fromEntries(formData);

	const body = data.payload;

	const postResponse = await fetch(API_URL + "products", {
		headers: {
			"Content-type": "application/json",
			"Authorization": "Bearer " + token.value
		},
		method: "PUT",
		body
	});

	const response = await postResponse.json();

	if(postResponse.ok)
	{
		if(response.items.length)
		{
			let items = "";

			for(let i of response.items)
			{
				items += "Producto con SKU " + i.sku + " actualizado\n";
			}

			alert(items);
		}

		if(response.errors.length)
		{
			let err_msg = "";

			for(let e of response.errors)
			{
				err_msg += e + "\n";
			}

			alert(err_msg);
		}
	}
	else
	{
		alert(response.message);
	}

	return false;
});
