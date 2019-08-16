(function()
 {
    function ValidatorObject(fieldName, requireClass, fieldElement, fieldsRules, answerError)
    {
        
        this.fieldName = fieldName;
        this.requireClass = requireClass;
        this.fieldElement = fieldElement;
        this.fieldsRules = fieldsRules;
        this.answerError = answerError;
        
        var currentObject = this;
        
        this.checkFields = function()
        {
            var fieldName = $(this.fieldName);
            
            fieldName.each(function(field)
            {
                field = fieldName.eq(field);
                
                if(field.find(currentObject.requireClass)[0] !== 'undefined')
                {
                    if(typeof currentObject.fieldElement == 'string')
                    {
                        currentObject.checklInputs(field, currentObject, k, currentObject.fieldElement);
                    }
                    else if(currentObject.fieldElement instanceof Array)
                    {
                        for(var k in currentObject.fieldElement)
                        {
                            currentObject.checklInputs(field, currentObject, k, currentObject.fieldElement[k]);
                        }
                    }
                }
            });
        }
        
        this.checklInputs = function(field, currentObject, k, fieldElement)
        {
            var element = field.parent().find(fieldElement);
            
            var fieldsRules = currentObject.fieldsRules;

            if(typeof fieldsRules[element.attr('name')] !== 'undefined')
            {
                if(typeof element[0].value !== 'undefined')
                {
                    for(var k in fieldsRules[element.attr('name')])
                    {  
                        if(k == 'minStr')
                        {
                            var elementParent = element.parent();

                            if(element.val().length < fieldsRules[element.attr('name')][k])
                            {

                                if(fieldsRules[element.attr('name')][k] < 2)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буква!', elementParent));
                                }
                                else if(fieldsRules[element.attr('name')][k] > 1 && fieldsRules[element.attr('name')][k] < 5)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буквы!', elementParent));
                                }
                                else
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' букв!', elementParent));
                                }
                            }
                        }
                        else if(k == 'maxStr')
                        {
                            var elementParent = element.parent();

                            if(element.val().length > fieldsRules[element.attr('name')][k])
                            {

                                if(fieldsRules[element.attr('name')][k] < 2)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буква!', elementParent));
                                }
                                else if(fieldsRules[element.attr('name')][k] > 1 && fieldsRules[element.attr('name')][k] < 5)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буквы!', elementParent));
                                }
                                else
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' букв!', elementParent));
                                }
                            }
                        }
                        else if(k == 'minInt')
                        {
                            var elementParent = element.parent();

                            if(element.val() < fieldsRules[element.attr('name')][k])
                            {
                                elementParent.append(currentObject.generateErrorMessage('Минимальное число ' + fieldsRules[element.attr('name')][k] + '!', elementParent));
                            }
                        }
                        else if(k == 'maxInt')
                        {
                            var elementParent = element.parent();

                            if(element.val() > fieldsRules[element.attr('name')][k])
                            {
                                elementParent.append(currentObject.generateErrorMessage('Максимальное число ' + fieldsRules[element.attr('name')][k] + '!', elementParent));
                            }
                        }
                        else if(k == 'isEmpty' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(element.val() == '')
                            {
                                elementParent.append(currentObject.generateErrorMessage('Строка должна быть заполнена!', elementParent));
                            }
                        }
                        else if(k == 'isString' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(typeof element.val() !== 'string')
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должен быть текст!', elementParent));
                            }
                        }
                        else if(k == 'isInteger' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(typeof element.val() !== 'number')
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должно быть число!', elementParent));
                            }
                        }
                        else if(k == 'isEmail' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(/.+?@.+?\..+/.test(element.val()) === false)
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должен быть адрес электронной почты!', elementParent));
                            }
                        }
                        else if(k == 'isValueSelected')
                        {

                            var elementParent = element.parent();

                            if(element[0].selectedIndex === 0)
                            {
                                elementParent.append(currentObject.generateErrorMessage('Выберите значение!', elementParent));
                            }
                        }
                        else if(k == 'comparePassword' && fieldsRules[element.attr('name')][k] !== '')
                        {
                            var elementParent = element.parent();
                            
                            if(element.val() !== fieldsRules[element.attr('name')][k])
                            {
                                elementParent.append(currentObject.generateErrorMessage('Пароли не совпадают!', elementParent));
                            }
                        }
                        else if(k == 'checkLogin' && typeof fieldsRules[element.attr('name')][k] !== 'undefined')
                        {
                            BX.ajax({
                                url: '/ajax/check-data.php?login=' + element.val(),
                                method: 'GET',
                                async: false,
                                cache: false,
                                onsuccess: function(result)
                                {
                                    if(fieldsRules[element.attr('name')][k].is === true)
                                    {
                                        if(result == true)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой логин уже существует!', elementParent));
                                        }
                                    }
                                    else
                                    {
                                        if(result == false)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой логин не существует!', elementParent));
                                        }
                                    }
                                }
                            });
                        }
                        else if(k == 'checkEmail' && typeof fieldsRules[element.attr('name')][k] !== 'undefined')
                        {
                            BX.ajax({
                                url: '/ajax/check-data.php?email=' + element.val(),
                                method: 'GET',
                                async: false,
                                cache: false,
                                onsuccess: function(result)
                                {
                                    if(fieldsRules[element.attr('name')][k].is === true)
                                    {
                                        if(result == true)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой email уже существует!', elementParent));
                                        } 
                                    }
                                    else
                                    {
                                        if(result == false)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой email не существует в базе данных!', elementParent));
                                        } 
                                    }

                                }
                            });
                        }
                        else if(k == 'isCheckCheckbox' && fieldsRules[element.attr('name')][k] === true)
                        {
                            if(element[0].checked != true)
                            {
                                element.next()[0].classList.add('error-checked');
                            }
                        }
                        else if(k == 'isUrl')
                        {
                            var elementParent = element.parent();
                            
                            if(element.val().match(/^http:\/\/|https:\/\//) === null)
                            {
                                elementParent.append(currentObject.generateErrorMessage('Введённое значение не является ссылкой!', elementParent));
                            }
                        }
                    }
                }
                else
                {
                    for(var k in fieldsRules[element.attr('name')])
                    {  
                        if(k == 'minStr')
                        {
                            var elementParent = element.parent();

                            if(element.html().length < fieldsRules[element.attr('name')][k])
                            {

                                if(fieldsRules[element.attr('name')][k] < 2)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буква!', elementParent));
                                }
                                else if(fieldsRules[element.attr('name')][k] > 1 && fieldsRules[element.attr('name')][k] < 5)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буквы!', elementParent));
                                }
                                else
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Минимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' букв!', elementParent));
                                }
                            }
                        }
                        else if(k == 'maxStr')
                        {
                            var elementParent = element.parent();

                            if(element.html().length > fieldsRules[element.attr('name')][k])
                            {

                                if(fieldsRules[element.attr('name')][k] < 2)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буква!', elementParent));
                                }
                                else if(fieldsRules[element.attr('name')][k] > 1 && fieldsRules[element.attr('name')][k] < 5)
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' буквы!', elementParent));
                                }
                                else
                                {
                                    elementParent.append(currentObject.generateErrorMessage('Максимальная длина предложения ' + fieldsRules[element.attr('name')][k] + ' букв!', elementParent));
                                }
                            }
                        }
                        else if(k == 'minInt')
                        {
                            var elementParent = element.parent();

                            if(element.html() < fieldsRules[element.attr('name')][k])
                            {
                                elementParent.append(currentObject.generateErrorMessage('Минимальное число ' + fieldsRules[element.attr('name')][k] + '!', elementParent));
                            }
                        }
                        else if(k == 'maxInt')
                        {
                            var elementParent = element.parent();

                            if(element.html() > fieldsRules[element.attr('name')][k])
                            {
                                elementParent.append(currentObject.generateErrorMessage('Максимальное число ' + fieldsRules[element.attr('name')][k] + '!', elementParent));
                            }
                        }
                        else if(k == 'isEmpty' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(element.html() == '')
                            {
                                elementParent.append(currentObject.generateErrorMessage('Строка должна быть заполнена!', elementParent));
                            }
                        }
                        else if(k == 'isString' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(typeof element.html() !== 'string')
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должен быть текст!', elementParent));
                            }
                        }
                        else if(k == 'isInteger' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(typeof element.html() !== 'number')
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должно быть число!', elementParent));
                            }
                        }
                        else if(k == 'isEmail' && fieldsRules[element.attr('name')][k] === true)
                        {
                            var elementParent = element.parent();

                            if(/.+?@.+?\..+/.test(element.html()) === false)
                            {
                                elementParent.append(currentObject.generateErrorMessage('В поле должен быть адрес электронной почты!', elementParent));
                            }
                        }
                        else if(k == 'isValueSelected')
                        {

                            var elementParent = element.parent();

                            if(element[0].selectedIndex === 0)
                            {
                                elementParent.append(currentObject.generateErrorMessage('Выберите значение!', elementParent));
                            }
                        }
                        else if(k == 'comparePassword' && fieldsRules[element.attr('name')][k] !== '')
                        {
                            var elementParent = element.parent();
                            
                            if(element.html() !== fieldsRules[element.attr('name')][k])
                            {
                                console.log(elementParent);
                                elementParent.append(currentObject.generateErrorMessage('Пароли не совпадают!', elementParent));
                            }
                        }
                        else if(k == 'checkLogin' && typeof fieldsRules[element.attr('name')][k] !== 'undefined')
                        {
                            BX.ajax({
                                url: '/ajax/check-data.php?login=' + element.val(),
                                method: 'GET',
                                async: false,
                                cache: false,
                                onsuccess: function(result)
                                {
                                    if(fieldsRules[element.attr('name')][k].is === true)
                                    {
                                        if(result == true)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой логин уже существует!', elementParent));
                                        }
                                    }
                                    else
                                    {
                                        if(result == false)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой логин не существует!', elementParent));
                                        }
                                    }
                                }
                            });
                        }
                        else if(k == 'checkEmail' && typeof fieldsRules[element.attr('name')][k] !== 'undefined')
                        {
                            BX.ajax({
                                url: '/ajax/check-data.php?email=' + element.val(),
                                method: 'GET',
                                async: false,
                                cache: false,
                                onsuccess: function(result)
                                {
                                    if(fieldsRules[element.attr('name')][k].is === true)
                                    {
                                        if(result == true)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой email уже существует!', elementParent));
                                        } 
                                    }
                                    else
                                    {
                                        if(result == false)
                                        {
                                            elementParent.append(currentObject.generateErrorMessage('Такой email не существует в базе данных!', elementParent));
                                        } 
                                    }

                                }
                            });
                        }
                        else if(k == 'isCheckCheckbox' && fieldsRules[element.attr('name')][k] === true)
                        {
                            if(element[0].checked != true)
                            {
                                element.next()[0].classList.add('error-checked');
                            }
                        }
                        else if(k == 'isUrl')
                        {
                            var elementParent = element.parent();
                            
                            if(element.html().match(/^http:\/\/|https:\/\//) === null)
                            {
                                elementParent.append(currentObject.generateErrorMessage('Введённое значение не является ссылкой!', elementParent));
                            }
                        }
                    }
                }
            }
        }
        
        this.generateErrorMessage = function(msg, parentElement){
            
            var msgElement = document.createElement('div');
            msgElement.className = this.answerError;
            msgElement.innerText = msg;
            
            if(typeof this.fieldElement == "string")
            {
                if(parentElement.find(this.fieldElement)[0].nodeName !== 'TEXTAREA' && !parentElement.find(this.fieldElement).hasClass('textarea-input'))
                {
                    msgElement.style.minHeight = parentElement.height() + 'px';
                }
            }
            else if(this.fieldElement instanceof Array)
            {
                for(var k in this.fieldElement)
                {
                    var elem = parentElement.find(this.fieldElement[k])[0];
                    
                    if(typeof elem !== 'undefined')
                    {
                        if(elem.nodeName !== 'TEXTAREA' && !elem.hasClass('textarea-input'))
                        {
                            msgElement.style.minHeight = parentElement.height() + 'px';
                        }
                    }
                }
            }
            
            msgElement.style.top = ( parentElement.height() + 5 ) + 'px';
            
            return msgElement;
        }
        
        function setEvent(currentObject)
        {
            function unsetErrorMsg()
            {
                var thisField = $(this);
                
                var errorMsg = thisField.parent().find('.' + currentObject.answerError);
                
                if(errorMsg[0] !== undefined)
                {
                    errorMsg.remove();
                }
            }
            
            var allInputs = $(currentObject.fieldElement);
            
            allInputs.on('focus', unsetErrorMsg);
            
            allInputs.each(function(input)
            {
                if(allInputs.eq(input).hasClass('textarea-input'))
                {
                    var textarea = allInputs.eq(input).parent().find('.chat-textarea');
                    
                    if(textarea[0] !== undefined)
                    {
                        textarea.on('focus', unsetErrorMsg);
                    }
                }
            });
        };
        
        setEvent(currentObject);
    }
    
    window.ValidatorObject = ValidatorObject;
})();