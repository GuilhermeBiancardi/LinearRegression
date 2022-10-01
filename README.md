# LinearRegression

## Inclusão da Classe

```php
    include_once "diretorio/LinearRegression.class.php";
```

## Chamada da Classe

```php
    $lr = new LinearRegression();
```

### Adicionando dados e fazendo a previsão

```php
    $eixoX = Array(1,2,3,4,5,6,7,8,9,...);
    $eixoY = Array(1,2,3,4,5,6,7,8,9,...);
    
    $lr->setData($eixoX, $eixoY);
    $predict = $lr->predict(10);
```

### Adicionando dados e fazendo a previsão com previsao x e y

```php
    $previsaoX = 11;
    $previsaoY = 11;
    
    $eixoX = Array(1,2,3,4,5,6,7,8,9,...);
    $eixoY = Array(1,2,3,4,5,6,7,8,9,...);
    
    $lr->setData($eixoX, $eixoY, $previsaoX, $previsaoY);
    $predict = $lr->predict(10);
```

Aproveitem!
