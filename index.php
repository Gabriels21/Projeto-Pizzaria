    <?php

    include_once('templates/header.php');
    include_once('process/pizza.php');

    ?>

    <div id="main-banner">
        <h1>Faça seu Pedido</h1>
    </div>
    
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Monte sua Pizza:</h2>
                    <form action="process/pizza.php" method="POST" id="pizza-form">
                        <div class="form-group">
                            <label for="borda">Borda:</label>
                            <select name="borda" id="borda" class="form-control">
                                <option value="">Escolha a borda de sua pizza</option>
                                    
                                    <?php foreach($bordas as $borda): ?>

                                        <option value="<?= $borda['id']?>"><?= $borda["tipo"]?></option>

                                    <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="massa">Massa:</label>
                            <select name="massa" id="massa" class="form-control">
                                <option value="">Escolha a massa de sua pizza</option>

                                <?php foreach($massas as $massa): ?>

                                    <option value="<?= $massa['id_massa']?>"><?= $massa["tipo_massa"]?></option>

                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="massa">Sabores: (Máximo 3)</label>
                            <select multiple name="sabores[]" id="sabores" class="form-control">

                                <?php foreach($sabores as $sabor): ?>

                                    <option value="<?= $sabor['id_sabor']?>"><?= $sabor["nome_sabor"]?></option>

                                <?php endforeach; ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Finalizar pedido">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php

    include_once('templates/footer.php');

    ?>