document.addEventListener("DOMContentLoaded", function() {
	var inputBusca = document.getElementById("campo_busca")
	var listaEnderecos = document.getElementById("address-list")

	async function buscarEnderecos(busca) {
		const url = new URL("../php/search_addresses.php", window.location.origin)
		url.searchParams.append("term", busca)
		const response = await fetch(url)
		if (response) {
			const data_1 = await response.json()
			return data_1
		} else return []
	}

	function atualizarLista(content) {
		if (content.length > 2) {
			buscarEnderecos(content).then((data) => {
				listaEnderecos.innerHTML = ""

				if (data.length === 0) {
					listaEnderecos.innerHTML = `
                        <div class="to_addlocal">
                            <p>Nenhum resultado encontrado</p>
                            <p>Deseja adicionar um novo local? <a href="add_local.php">Clique aqui</a></p>
                        </div>
                    `
				} else {
					data.forEach((item) => {
						const listItem = document.createElement("div")
						listItem.className = "item_address"
						listItem.setAttribute("data-nome-local", item.nome_local)
						listItem.setAttribute("data-rua", item.rua)
						listItem.innerHTML = `<h2>${item.nome_local}</h2><h3>${item.rua}</h3>`
						listaEnderecos.appendChild(listItem)

						listItem.addEventListener("click", function() {
							window.location.href = "address_details.php?id=" + item.id
						})
					})
				}
			})
		} else listaEnderecos.innerHTML = ""
	}

	function shouldSearch(content) {
		let lowerContent = content.toLowerCase()
		if (lowerContent.startsWith("rua")) {
			return lowerContent.length > 4
		}
		return content.length > 3
	}

	inputBusca.addEventListener("input", function() {
		var content = this.value.trim()
		if (shouldSearch(content)) {
			atualizarLista(content)
		} else listaEnderecos.innerHTML = ""
	})
})