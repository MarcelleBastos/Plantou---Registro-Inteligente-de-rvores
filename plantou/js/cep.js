document.getElementById('cep').addEventListener('blur', function(buscarCep){
    const cep = document.querySelector('#cep').value.replace(/\D/g, '');
    if (cep.length !== 8) {
        alert('CEP inválido!');
        return;
    }

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
    .then(response => response.json())
    .then(data => {
        if (data.erro) {
            alert('CEP não encontrado!');
            return;
        }

        document.querySelector('#city').value = data.localidade;
        document.querySelector('#neighboorhood').value = data.bairro;
        document.querySelector('#street').value = data.logradouro;
        document.querySelector('#uf').value = data.uf;
        document.querySelector('#state').value = data.estado;
    })
    
    .catch(error => {
        alert('Erro ao buscar cep');
        console.error(error);
        });
})