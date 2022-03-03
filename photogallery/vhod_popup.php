<div id="vhod_popup" class="popup">
    <a href="#header" class="popup__area"></a>
    <div class="popup__body">
        <div class="popup__content">
            <a href="#header" class="popup__close">Х</a>
            <form action="vhod.php" method="POST" class="formVhod" id="form_vhod">
                <fieldset>
                    <legend>Вход</legend>
                    <p class="popup__pole" id="vhod_email"><label for="emailVhod">Имейл</label><input name="vhod_email" type="email" id="emailVhod" title="primer@primer.com(ru)" required pattern="[a-zA-Z]\S{2,30}@\w+\.(com|ru)"></p>
                    <p class="popup__pole" id="vhod_pass"><label for="password">Пароль</label><input name="vhod_pass" type="password" id="passVhod" title="Одна заглавная, строчная буквы, цифра, спец-символ" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,30}"></p>
                    <input type="submit" class="popup__otpravka" value="Войти">
                </fieldset>
            </form>
            <div class="popup__lowlink">
                <a href="#registration_popup">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</div>