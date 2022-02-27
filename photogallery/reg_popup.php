<div id="registration_popup" class="popup">
        <a href="#header" class="popup__area"></a>
        <div class="popup__body">
            <div class="popup__content">
                <a href="#header" class="popup__close">Х</a>
                <form action="registration.php" method="POST" class="formRegistration" id="register_form">
                    <fieldset>
                        <legend>Регистрация</legend>
                        <p class="popup__pole" id="reg_name"><label for="name">Имя</label><input name="reg_name" type="text" id="name" title="На русском, разрешены пробелы и дефис (но не последними символами)" required pattern="^[А-Я|а-я]{1}[А-Я|а-я\- ]{0,23}[А-Я|а-я]{1}$"></p>
                        <p class="popup__pole" id="reg_email"><label for="emailReg">Имейл</label><input name="reg_email" type="email" id="emailReg" title="primer@primer.com(ru)" required pattern="[a-zA-Z]\S{2,30}@\w{1,10}\.(com|ru)"></p>
                        <p class="popup__pole" id="reg_telefon"><label for="telefon">Телефон</label><input name="reg_telefon" type="tel" id="telefon" title="8/+7 и 10 цифр" required pattern="^8\d{10}|^\+7\d{10}"></p>
                        <p class="popup__pole" id="reg_pass_1"><label for="password">Пароль</label><input id="pass" name="reg_pass_1" type="password" onchange="sravnPass()" title="Одна заглавная, строчная буквы, цифра, спец-символ" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,30}"></p>
                        <p class="popup__pole" id="reg_pass_2"><label for="password">Повторите пароль</label><input name="reg_pass_2" id="povtPass" type="password" onchange="sravnPass()" title="Должно быть полное совпадение с прошлым полем =)" required pattern="(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,30}"></p>
                        <p class="popup__pole" id="reg_usl"><input name="reg_usl" type="checkbox" value="Принял" required>Я принимаю условия пользовательского соглашения</p>
                        <input type="submit" class="popup__otpravka" id="popup__otpravkaReg" disabled value="Зарегистрироваться">
                    </fieldset>
                </form>
                <div class="popup__lowlink">
                    <a href="#vhod_popup">Войти</a>
                </div>
            </div>
        </div>
    </div>