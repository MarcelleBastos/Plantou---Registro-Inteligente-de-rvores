// ===== MÁSCARAS DE ENTRADA =====
function aplicarMascaraCPF(input) {
    let valor = input.value.replace(/\D/g, '');
    if (valor.length > 11) valor = valor.slice(0, 11);
    
    if (valor.length <= 3) {
        input.value = valor;
    } else if (valor.length <= 6) {
        input.value = valor.slice(0, 3) + '.' + valor.slice(3);
    } else if (valor.length <= 9) {
        input.value = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6);
    } else {
        input.value = valor.slice(0, 3) + '.' + valor.slice(3, 6) + '.' + valor.slice(6, 9) + '-' + valor.slice(9);
    }
}

function aplicarMascaraTelefone(input) {
    let valor = input.value.replace(/\D/g, '');
    if (valor.length > 11) valor = valor.slice(0, 11);
    
    if (valor.length <= 2) {
        input.value = valor;
    } else if (valor.length <= 7) {
        input.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2);
    } else {
        input.value = '(' + valor.slice(0, 2) + ') ' + valor.slice(2, 7) + '-' + valor.slice(7);
    }
}

// Adicionar event listeners para máscaras
document.getElementById('cpf').addEventListener('input', function() {
    aplicarMascaraCPF(this);
});

document.getElementById('phone').addEventListener('input', function() {
    aplicarMascaraTelefone(this);
});

// ===== VALIDAÇÃO DE SENHA COM FEEDBACK =====
function verificarSenhas() {
    const senha = document.getElementById('password').value;
    const confirmar = document.getElementById('confirm-password').value;
    const erroSenha = document.getElementById('erroSenha');
    const critérios = document.getElementById('senha-criteria');

    // Critérios de senha
    const temMinuscula = /[a-z]/.test(senha);
    const temMaiuscula = /[A-Z]/.test(senha);
    const temNumero = /\d/.test(senha);
    const temEspecial = /[@$!%*#?&.,;:]/.test(senha);
    const temTamanho = senha.length >= 8;

    // Mostrar critérios
    if (critérios) {
        let html = '<div style="font-size: 12px; color: #999; margin-top: 8px;">';
        html += '<p style="margin-bottom: 8px; font-weight: 600;">Critérios de senha:</p>';
        html += '<p style="margin: 4px 0;"><span style="color: ' + (temMinuscula ? '#4caf50' : '#ff6b6b') + ';">● Letras minúsculas</span></p>';
        html += '<p style="margin: 4px 0;"><span style="color: ' + (temMaiuscula ? '#4caf50' : '#ff6b6b') + ';">● Letras maiúsculas</span></p>';
        html += '<p style="margin: 4px 0;"><span style="color: ' + (temNumero ? '#4caf50' : '#ff6b6b') + ';">● Números</span></p>';
        html += '<p style="margin: 4px 0;"><span style="color: ' + (temEspecial ? '#4caf50' : '#ff6b6b') + ';">● Caracteres especiais (@$!%*#?&.,;:)</span></p>';
        html += '<p style="margin: 4px 0;"><span style="color: ' + (temTamanho ? '#4caf50' : '#ff6b6b') + ';">● Mínimo 8 caracteres</span></p>';
        html += '</div>';
        critérios.innerHTML = html;
    }

    // Validar combinações
    if (senha.length > 0) {
        if (!temMinuscula || !temMaiuscula || !temNumero || !temEspecial || !temTamanho) {
            erroSenha.textContent = 'Senha não atende aos critérios acima';
            erroSenha.className = 'erro show';
        } else {
            erroSenha.textContent = '';
            erroSenha.className = 'erro';
        }
    }

    // Verificar confirmação
    if (confirmar.length > 0) {
        if (senha !== confirmar) {
            erroSenha.textContent = 'As senhas não coincidem!';
            erroSenha.className = 'erro show';
        } else if (temMinuscula && temMaiuscula && temNumero && temEspecial && temTamanho) {
            erroSenha.textContent = 'Senhas válidas e coincidem.';
            erroSenha.className = 'ok show';
        }
    }
}

// Adicionar event listeners para validação de senha
document.getElementById('password').addEventListener('input', verificarSenhas);
document.getElementById('confirm-password').addEventListener('input', verificarSenhas);

document.getElementById("form").addEventListener("submit", function(e) {
    if (!validarFormulario()) {
        e.preventDefault(); // impede envio se for inválido
    }
});




function validaCpf() {
    let cpf = document.getElementById('cpf').value;
    const erroCpf = document.getElementById('erroCpf');
    cpf = cpf.replace(/\D/g, '');

    if (/^(\d)\1{10}$/.test(cpf)) {
        erroCpf.textContent = 'CPF inválido (todos os dígitos iguais)';
        erroCpf.className = 'erro';
        return false;
    }

    if (cpf.length !== 11) {
        erroCpf.textContent = 'Seu Cpf deverá ter 11 dígitos';
        erroCpf.className = 'erro';
        return false;
    }

    const proximoDigitoVerificador = (cpfIncompleto) => {
        let somatoria = 0;
        for (let i = 0; i < cpfIncompleto.length; i++) {
            let digitoAtual = cpfIncompleto.charAt(i);
            let constante = (cpfIncompleto.length + 1 - i);
            somatoria += Number(digitoAtual) * constante;
        }
        const resto = somatoria % 11;
        return resto < 2 ? '0' : (11 - resto).toString();
    };

    let primeiroDV = proximoDigitoVerificador(cpf.substring(0, 9));
    let segundoDV = proximoDigitoVerificador(cpf.substring(0, 9) + primeiroDV);
    let cpfCorreto = cpf.substring(0, 9) + primeiroDV + segundoDV;

    if (cpf !== cpfCorreto) {
        erroCpf.textContent = 'Verificadores não conferem';
        erroCpf.className = 'erro';
        return false;
    } else {
        erroCpf.textContent = 'Cpf válido';
        erroCpf.className = 'ok';
        return true;
    }
}

// Valida celular brasileiro: DDD (2 dígitos) + número com 9 dígitos (começando com 9)
function validaCelular() {
    const telefoneEl = document.getElementById('phone');
    const erroPhone = document.getElementById('erroPhone');
    let telefone = telefoneEl.value || '';
    telefone = telefone.replace(/\D/g, ''); // remove não dígitos

    // Aceita formatos com DDI 55 ou sem. Normalizamos para sem DDI.
    if (telefone.startsWith('55') && telefone.length > 11) {
        telefone = telefone.slice(2);
    }

    // Agora deve ter exatamente 11 dígitos: 2 do DDD + 9 do número
    if (telefone.length !== 11) {
        erroPhone.textContent = 'Celular inválido: deve conter DDD + 9 dígitos (ex: 11999999999)';
        erroPhone.className = 'erro show';
        return false;
    }

    const ddd = telefone.substring(0, 2);
    const primeiroNumero = telefone.charAt(2);

    // DDD não pode começar com 0 or 1 (mais estrito: DDD válido entre 11 e 99, mas não 00)
    if (!/^[1-9][0-9]$/.test(ddd)) {
        erroPhone.textContent = 'DDD inválido';
        erroPhone.className = 'erro show';
        return false;
    }

    // Número móvel deve começar com 9
    if (primeiroNumero !== '9') {
        erroPhone.textContent = 'Número móvel inválido: deve começar com 9';
        erroPhone.className = 'erro show';
        return false;
    }

    // Se passou, é válido
    erroPhone.textContent = 'Celular válido';
    erroPhone.className = 'ok show';
    return true;
}

function validarFormulario() {
    const nome = document.getElementById("name").value.trim();
    const email = document.getElementById('email').value.trim();
    const erroEmail = document.getElementById('erroEmail');
    const date = document.getElementById("birth").value;
    const nomeMaterno = document.getElementById("motherName").value.trim();
    const cpf = document.getElementById("cpf").value.trim();
    const telefone = document.getElementById("phone").value.trim();
    const endCep = document.getElementById("cep").value.trim();
    const endCidade = document.getElementById("city").value.trim();
    const endBairro = document.getElementById("neighboorhood").value.trim();
    const endLogradouro = document.getElementById("street").value.trim();
    const endNumero = document.getElementById("number").value.trim();
    const endUf = document.getElementById("uf").value.trim();
    const endEstado = document.getElementById("state").value.trim();
    const senha = document.getElementById('password').value.trim();
    const confirmar = document.getElementById('confirm-password').value.trim();
    const genero = document.querySelector('input[name="gender"]:checked');

    // Verificar campos vazios
    const campos = {
        'Nome Completo': nome,
        'E-mail': email,
        'Data de Nascimento': date,
        'Nome da Mãe': nomeMaterno,
        'CPF': cpf,
        'Celular': telefone,
        'CEP': endCep,
        'Cidade': endCidade,
        'Bairro': endBairro,
        'Rua': endLogradouro,
        'Número': endNumero,
        'UF': endUf,
        'Estado': endEstado,
        'Senha': senha,
        'Confirmar Senha': confirmar,
        'Gênero': genero ? 'ok' : ''
    };

    let camposFaltando = [];
    for (const [label, valor] of Object.entries(campos)) {
        if (!valor || valor === '') {
            camposFaltando.push(label);
        }
    }

    if (camposFaltando.length > 0) {
        alert('Campos obrigatórios faltando:\n\n• ' + camposFaltando.join('\n• '));
        return false;
    }

    const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ ]{15,80}$/;

    if (!regexNome.test(nome)) {
        alert("O nome deve ter de 15 a 80 letras.");
        return false;
    }

    const dataNascimento = new Date(date);
    const hoje = new Date();
    const minData = new Date(hoje.getFullYear() - 90, hoje.getMonth(), hoje.getDate());
    const maxData = new Date(hoje.getFullYear() - 18, hoje.getMonth(), hoje.getDate());

    if (dataNascimento < minData || dataNascimento > maxData) {
        alert("A data de nascimento deve indicar idade entre 18 e 90 anos.");
        return false;
    }

    if (!regexNome.test(nomeMaterno)) {
        alert("O nome materno deve ter de 15 a 80 letras.");
        return false;
    }

    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        erroEmail.textContent = "E-mail inválido!";
        return false;
    } else {
        erroEmail.textContent = "";
    }

    // Validar celular (DDD + 9 dígitos)
    if (!validaCelular()) {
        // validaCelular já mostra mensagem inline
        return false;
    }

    const regexEndereco = /^[A-Za-zÀ-ÖØ-öø-ÿ0-9 ]{2,200}$/;
    if (!regexEndereco.test(endCidade)) {
        alert("Escreva a Cidade corretamente, somente caracteres alfabéticos válidos!");
        return false;
    }

    if (!regexEndereco.test(endBairro)) {
        alert("Escreva o Bairro corretamente, somente caracteres alfabéticos válidos!");
        return false;
    }

    if (!regexEndereco.test(endLogradouro)) {
        alert("Escreva a Rua corretamente, somente caracteres alfabéticos válidos!");
        return false;
    }

    if (!regexEndereco.test(endUf)) {
        alert("Escreva a UF corretamente, somente caracteres alfabéticos válidos!");
        return false;
    }

    if (!regexEndereco.test(endEstado)) {
        alert("Escreva o Estado corretamente, somente caracteres alfabéticos válidos!");
        return false;
    }

    const regexSenha = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&.,;:])[A-Za-z\d@$!%*#?&.,;:]{8,}$/;
    if (!regexSenha.test(senha)) {
        alert("A senha não atende aos critérios de segurança.");
        return false;
    }

    if (senha !== confirmar) {
        alert("As senhas não coincidem!");
        return false;
    }

    if (!validaCpf()) {
        alert("Cpf inválido");
        return false;
    }

    return true;
}