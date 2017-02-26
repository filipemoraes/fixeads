<?php $this->block('body'); ?>
    <div class="wrapper">
        <header>
            <h1>Registe-se gratuitamente</h1>
            <h2>Registe-se de forma fácil e rápida. O registo é rápido e grátis.</h2>
        </header>
    </div>
    <div class="wrapper wrapper-grey">
        <form name="register" id="register">
            <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->crsftoken; ?>" />
            <div class="register__field col col-100">
                <div class="title col col-20">Email <span>*</span></div>
                <div class="input col col-60"><input type="text" name="email" id="email" /></div>
                <div class="error col col-100" id="email--error"></div>
                <img src="/public/images/loading.gif" class="loading" id="loading" />
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">Confirmar Email <span>*</span></div>
                <div class="input col col-60"><input type="text" name="copyemail" id="copyemail" /></div>
                <div class="error col col-100" id="copyemail--error"></div>
            </div>
            <div class="register__field col col-100 divider">
                <div class="title col col-20">Password <span>*</span></div>
                <div class="input col col-30"><input type="password" name="password" id="password" /></div>
                <div class="error col col-100" id="password--error"></div>
                <div class="ckeckpassword">
                    A sua password é segura?
                    <br/>
                    Pouco segura&nbsp;&nbsp;<div class="bar"><span id="bar__status"></span></div>&nbsp;&nbsp;Muito segura
                </div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">Confirmar Password <span>*</span></div>
                <div class="input col col-30"><input type="password" name="copypassword" id="copypassword" /></div>
                <div class="error col col-100" id="copypassword--error"></div>
            </div>
            <div class="register__field col col-100 divider">
                <div class="title col col-20">Nome <span>*</span></div>
                <div class="input col col-30"><input type="text" name="firstname" id="firstname" placeholder="Nome" /></div>
                <div class="input col col-30"><input type="text" name="lastname" id="lastname" placeholder="Apelido" /></div>
                <div class="error col col-100" id="firstname--error"></div>
                <div class="error col col-100" id="lastname--error"></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">Rua / Nº</div>
                <div class="input col col-60"><input type="text" name="address" id="address" /></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">Código Postal / Localidade</div>
                <div class="input col col-20">
                    <input type="text" name="zipcode" id="zipcode" placeholder="Ex. 9999-999" />
                </div>
                <div class="input col col-40"><input type="text" name="city" id="city" /></div>
                <div class="error col col-100" id="zipcode--error"></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">País</div>
                <div class="input col col-30">
                    <select name="country" id="country">
                        <option value=""></option>
                        <option value="PT">Portugal</option>
                        <option value="BR">Brasil</option>
                        <option value="ES">Espanha</option>
                        <option value="NL">Holanda</option>
                    </select>
                </div>
                <div class="error col col-100" id="country--error"></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">NIF</div>
                <div class="input col col-30"><input type="text" name="nif" id="nif" /></div>
                <div class="error col col-100" id="nif--error"></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">Telefone</div>
                <div class="input col col-30">
                    <input type="text" name="phone" id="phone" placeholder="Insira o número aqui" />
                </div>
                <div class="error col col-100" id="phone--error"></div>
            </div>
            <div class="register__field col col-100">
                <div class="title col col-20">&nbsp</div>
                <div class="input col col-30">
                    <div class="button" id="submit">
                        Registo
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="dialog" id="dialog">
        <div class="dialog__wrapper">
            <div class="dialog__title" id="dialog__title"></div>
            <div class="dialog__text" id="dialog__text"></div>
        </div>
    </div>
<?php $this->endBlock(); ?>
<?php $this->extend('base'); ?>
