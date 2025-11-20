
document.addEventListener('DOMContentLoaded', function() {
    const lista = document.getElementById('listaRegistros');

    if (lista) {
        carregarRegistros();
    }
});


const formulario = document.getElementById('cadastroForm')
const lista = document.getElementById('listaRegistros')



formulario.addEventListener('submit', function(evento) {
    evento.preventDefault(); // Impede a página de recarregar

 
    const dadosFormulario = {
        tipo: document.getElementById('tipo').value,
        nome: document.getElementById('nome').value,
        cpf: document.getElementById('cpf').value,
        telefone: document.getElementById('telefone').value
    };

    fetch('salvar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosFormulario)
    })
    .then(resposta => resposta.json())
    .then(dados => {
        if(dados.sucesso) {
            alert(dados.msg);
            // Se o cadastro foi um sucesso, recarrega a lista
            carregarRegistros(); 
            formulario.reset(); 
        } else {
            alert("Erro ao cadastrar: " + dados.msg);
        }
    })
    .catch(erro => console.error('Erro de submissão:', erro));
});

document.addEventListener('DOMContentLoaded', carregarRegistros);

function carregarRegistros() {
    const lista = document.getElementById('listaRegistros'); // Busca a lista dentro da função
    if (!lista) return; // Se não encontrou, sai

    fetch('listar.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao carregar os dados do servidor');
        }
        return response.json();
    })
    .then(data => {
        lista.innerHTML = ''; 
        data.forEach(item => {
            // Note: AdicionarNaLista precisa usar a variável lista passada/definida
            adicionarNaLista(item);
        });
    })
    .catch(error => console.error('Erro de carregamento:', error));
}



lista.addEventListener('click', lidarComDelecao);

function lidarComDelecao(e) {
    if (e.target.classList.contains('btn-deletar')) {
        const id = e.target.dataset.id;
        
        if (!confirm(`Tem certeza que deseja deletar o registro ID ${id}?`)) {
            return; 
        }

        fetch('deletar.php', {
            method: 'DELETE', 
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                alert(data.msg);
                // Remove o item da lista visualmente
                e.target.parentElement.remove(); 
            } else {
                alert(`Erro ao deletar: ${data.msg}`);
            }
        })
        .catch(error => console.error('Erro de deleção:', error));
    }
}



// script.js - FUNÇÃO VISUAL (RENDERING) ATUALIZADA

// script.js - FUNÇÃO VISUAL (RENDERING) ATUALIZADA E ALINHADA

function adicionarNaLista(item) {
    const li = document.createElement('li');
    
    // Contêiner para as informações do registro
    const infoSpan = document.createElement('span');
    infoSpan.classList.add('registro-info');
    infoSpan.innerHTML = `
        ${item.tipo.toUpperCase()}: 
        <strong>${item.nome}</strong> 
        | CPF: ${item.cpf} 
        | Tel: ${item.telefone}
    `;
    
    // Contêiner para os botões
    const actionsDiv = document.createElement('div');
    actionsDiv.classList.add('registro-actions');


    // 1. Botão Deletar
    const btnDeletar = document.createElement('button');
    btnDeletar.textContent = 'Deletar';
    btnDeletar.classList.add('btn-deletar');
    btnDeletar.dataset.id = item.id; 

    // 2. Botão Editar
    const btnEditar = document.createElement('button');
    btnEditar.textContent = 'Editar';
    btnEditar.classList.add('btn-editar'); 
    
    // Anexa os dados completos para preencher o formulário de edição
    btnEditar.dataset.id = item.id;
    btnEditar.dataset.tipo = item.tipo;
    btnEditar.dataset.nome = item.nome;
    btnEditar.dataset.cpf = item.cpf;
    btnEditar.dataset.telefone = item.telefone; 

    
    // 3. Montagem
    actionsDiv.appendChild(btnEditar); 
    actionsDiv.appendChild(btnDeletar);
    
    li.appendChild(infoSpan); // Adiciona as informações
    li.appendChild(actionsDiv); // Adiciona os botões
    lista.appendChild(li); 
}
// script.js - LÓGICA DE EDIÇÃO (UPDATE)

// Adicione este listener DENTRO do bloco document.addEventListener('DOMContentLoaded', function() { ... })
// O listener já está ativo na 'lista', mas precisamos verificar o clique no 'btn-editar'

if (lista) {
    lista.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-editar')) {
            const btn = e.target;
            
            // 1. Preenche o Modal/Formulário com os dados
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-tipo').value = btn.dataset.tipo;
            document.getElementById('edit-nome').value = btn.dataset.nome;
            document.getElementById('edit-cpf').value = btn.dataset.cpf;
            document.getElementById('edit-telefone').value = btn.dataset.telefone;
            
            // 2. Torna o Modal visível (Você precisa adicionar o CSS para isso!)
            document.getElementById('editModal').style.display = 'block';
        }
    });
}

// Lógica de envio do formulário de Edição
const editForm = document.getElementById('editForm');
if (editForm) {
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const dadosEditados = {
            id: document.getElementById('edit-id').value,
            tipo: document.getElementById('edit-tipo').value,
            nome: document.getElementById('edit-nome').value,
            cpf: document.getElementById('edit-cpf').value,
            telefone: document.getElementById('edit-telefone').value
        };

        fetch('editar.php', { // Novo arquivo PHP
            method: 'PUT', // Método PUT (boa prática para updates)
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dadosEditados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                alert(data.msg);
                document.getElementById('editModal').style.display = 'none';
                carregarRegistros(); // Recarrega a lista para mostrar a alteração
            } else {
                alert("Erro ao editar: " + data.msg);
            }
        })
        .catch(error => console.error('Erro de edição:', error));
    });
}