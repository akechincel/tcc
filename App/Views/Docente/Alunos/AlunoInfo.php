<form>
    <h2>Cadastrar Aluno</h2>
    <input type="text" name="nome" placeholder="Nome" value="<?= $this->aluno->nome_aluno ?>" disabled/>
    <input type="tel" name="telefone" placeholder="Telefone" value="<?= $this->aluno->telefone_aluno ?>" disabled/>
    <input type="number" name="cpf" placeholder="CPF" value="<?= $this->aluno->cpf_aluno ?>" disabled/>
    <input type="number" name="rg" placeholder="RG" value="<?= $this->aluno->rg_aluno ?>" disabled/>
    <input type="email" name="email" placeholder="Email" value="<?= $this->aluno->email_aluno ?>" disabled/>
    <input type="date" name="nascimento" placeholder="Nascimento" value="<?= $this->aluno->nascimento_aluno ?>" disabled/>
    <!-- Endereço -->
    <fieldset style="width: 100%;">
        <legend>Endereço</legend>
        <section>
            <div>
                <label for="cep">CEP</label>
                <input type="number" name="cep" id="cep" placeholder="CEP" required value="<?= $this->aluno->cep ?>" disabled/>
                <p id="ceperro" style="color: #f00;"></p>
            </div>
            <div>
                <label for="uf">UF</label>
                <select name="uf" id="uf" required disabled>
                    <option value="">Selecione um Estado</option>
                </select>
            </div>
            <div>
                <label for="localidade">Cidade</label>
                <select name="localidade" id="localidade" required disabled>
                    <option value="">Selecione um Cidade</option>
                </select>
            </div>
        </section>
        <label for="bairro">Bairro</label>
        <input type="text" name="bairro" id="bairro" placeholder="Bairro" required value="<?= $this->aluno->bairro ?>" disabled/>
        <section>
            <fieldset style="flex: 14;">
                <label for="logradouro">Rua</label>
                <input type="text" name="logradouro" id="logradouro" placeholder="Rua" required value="<?= $this->aluno->logradouro ?>" disabled/>
            </fieldset>
            <fieldset style="flex: 1;">
                <label for="numero">Número</label>
                <input type="number" name="numero" id="numero" placeholder="Número" min="1" required value="<?= $this->aluno->numero ?>" disabled/>
            </fieldset>
        </section>
        <label for="complemento">Complemeto</label>
        <input type="text" name="complemento" id="complemento" placeholder="Complemento" value="<?= $this->aluno->complemento ?>" disabled/>
    </fieldset>
    <fieldset>
        <legend>Responsavel</legend>
        <input type="text" name="nome_responsavel" placeholder="Nome do Responsável" value="<?= $this->aluno->nome_responsavel ?>" disabled/>
        <input type="tel" name="telefone_responsavel" placeholder="Telefone do Responsável" value="<?= $this->aluno->telefone_responsavel ?>" disabled/>
        <input type="number" name="cpf_responsavel" placeholder="CPF do Responsável" value="<?= $this->aluno->cpf_responsavel ?>" disabled/>
        <input type="number" name="rg_responsavel" placeholder="RG do Responsável" value="<?= $this->aluno->rg_responsavel ?>" disabled/>
    </fieldset>
    <button type="button" id="editar">Editar</button>
    <button type="button" id="cancelar" style="display: none">Cancelar</button>
    <input type="submit" value="Atualizar" style="display: none" disabled/>
    <p id="formretorno"></p>
    <script>
        var searchCities = async (callback) => {
            $("form select#localidade").prop("disabled", false);
            await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${$("form select#uf").val()}/distritos`)
                .then((response) => {
                    if (!response.ok) {
                        return;
                    }
                    return response.json();
                })

                .then((cities) => {
                    cities = cities.sort((a, b) => {
                        // ordenando pelo nome
                        if (a.nome < b.nome) {
                            return -1;
                        }
                    });

                    $("select#localidade").empty();
                    cities.map((city) => {
                        const option = document.createElement("option");
                        option.setAttribute("value", city.nome);
                        option.textContent = city.nome;

                        $("select#localidade").append(option);
                    });
                });

            callback(); // somente preencher as informações quando a requisição for concluida
        };

        $(document).ready(async function () {
            await fetch("https://servicodados.ibge.gov.br/api/v1/localidades/estados")
                .then((response) => {
                    if (!response.ok) {
                        return;
                    }
                    return response.json();
                })

                .then((states) => {
                    states = states.sort((a, b) => {
                        // ordenando pela sigla
                        if (a.sigla < b.sigla) {
                            return -1;
                        }
                    });

                    states.map((state) => {
                        const option = document.createElement("option");
                        option.setAttribute("value", state.sigla);
                        option.textContent = state.nome;
                        
                        $("select#uf").append(option);
                    });
                    $('select#uf').val('<?= $this->aluno->uf ?>')
                    searchCities(function () {
                        $('select#localidade').val('<?= $this->aluno->cidade ?>')
                        $("form select#localidade").prop("disabled", true)
                    })
                });
        });

        // colocar as cidades no select
        $("form select#uf").change(searchCities);

        // consulta do cep
        $("form input#cep").change(function () {
            $("form input#cep + p").remove();
            fetch(`https://viacep.com.br/ws/${$(this).val()}/json/`)
                .then((response) => {
                    if (!response.ok) {
                        return;
                    }
                    return response.json();
                })

                .then((cep) => {
                    if (cep?.erro) {
                        throw new Error();
                    }
                    $("form select#uf").val(cep.uf);

                    searchCities(function () {
                        // callback
                        $("form select#localidade").val(cep.localidade);
                        $("form input#bairro").val(cep.bairro);
                        $("form input#logradouro").val(cep.logradouro);
                    });
                })

                .catch(() => {
                    const p = document.createElement("p");
                    p.textContent = "Informe um CEP válido";
                    p.style.color = "#fd2419";
                    $(this).parent().append(p);
                });
        });

        $('form button#editar').click(function () {
            $('form input').each(function () {
                $(this).prop("disabled", false)
            })
            $('form select#uf').prop('disabled', false)
            $('form select#localidade').prop('disabled', false)
            $(this).css('display', 'none')
            $('form button#cancelar').css('display', 'block')
            $('form input[type="submit"]').css('display', 'block')
        })

        $('form button#cancelar').click(function () {
            window.location.reload()
        })

        $("form").on("submit", function (event) {
            event.preventDefault(); // impede que a pagina seja recarregada

            $.ajax({
                url: "/docente/aluno/<?= $this->aluno->cd_aluno ?>/info",
                type: "post",
                dataType: "json",
                data: $("form").serialize(),
                success: function (data) {
                    if (data.ok) {
                        $('p#formretorno').text('Aluno Atualizado')
                        $('form input').each(function () {
                            $(this).prop('disabled', true)
                        })
                        $('form input[type="submit"]').css('display', 'none')
                        $('form button#cancelar').css('display', 'none')
                        $('form button#editar').css('display', 'block')
                        $("form select#uf").prop("disabled", true);
                        $("form select#localidade").prop("disabled", true);
                        return;
                    }
                    $('p#formretorno').text(data.msg)
                },
            });
        });
    </script>
</form>
