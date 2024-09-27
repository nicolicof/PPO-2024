// Função que remove acentos
function removerAcentos(texto) {
    return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Função que verifica se há repetição de letras consecutivas acima do limite
function verificarRepeticao(texto, limite) {
    const regex = new RegExp(`(.)\\1{${limite},}`, 'g'); // Detecta repetição de uma única letra
    return regex.test(texto); // Retorna true se encontrar mais de 'limite' repetições consecutivas
}

// Função que verifica padrões curtos repetidos (como "asdasdasd")
function verificarPadroesRepetidos(texto, limite) {
    const regexPadroes = new RegExp(`(\\w{2,3})\\1{${limite},}`, 'g'); // Detecta padrões de 2 ou 3 letras repetidos
    return regexPadroes.test(texto);
}

// Processa o texto: remove acentos e converte para minúsculas
function processarTexto(texto) {
    let textoMinusculo = texto.toLowerCase();
    return removerAcentos(textoMinusculo);
}

// Carrega a lista de palavras feias do arquivo
let palavrasFeias = [];
fetch('words.txt')
    .then(response => {
        if (!response.ok) {
            throw new Error("Erro ao carregar palavras feias.");
        }
        return response.text();
    })
    .then(data => {
        palavrasFeias = data.split('\n').map(palavra => palavra.trim().toLowerCase());
    })
    .catch(error => {
        console.error('Erro ao carregar palavras feias:', error);
    });

// Verifica o texto do campo de reclamação
function verificarTexto() {
    let reclamacao = document.getElementById('reclamacao').value.trim().toLowerCase();
    
    // Verifica se o campo está vazio
    if (reclamacao === "") {
        alert("Por favor, preencha o campo de descrição.");
        return false;
    }

    // Processa o texto: remove acentos
    reclamacao = processarTexto(reclamacao);

    // Verifica se há repetição de letras consecutivas acima do limite (exemplo: mais de 2 repetições)
    if (verificarRepeticao(reclamacao, 2)) {
        alert("Por favor, evite repetir letras consecutivas mais de 2 vezes.");
        return false;
    }

    // Verifica se há padrões repetidos (exemplo: asdasdasd)
    if (verificarPadroesRepetidos(reclamacao, 2)) { // Limite de 2 repetições do padrão
        alert("Por favor, evite repetir padrões de letras curtos.");
        return false;
    }

    // Verifica se o texto contém palavras feias
    for (let palavra of palavrasFeias) {
        if (palavra.length > 0 && reclamacao.includes(palavra)) { // Ignora palavras vazias
            alert("Por favor, não use linguagem inapropriada!");
            return false;
        }
    }

    return true; // Se passou por todas as verificações, retorna true
}
