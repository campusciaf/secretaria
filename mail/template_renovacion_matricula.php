<?php
require_once "send_renovacion_matricula.php";
function template_renovacion_matricula($valor_matricula){
    $veinte_por_ciento = $valor_matricula * 0.20;
    $total_a_financiar = $valor_matricula - $veinte_por_ciento; 
    $tres_cuotas = $total_a_financiar/3;
    $cuatro_cuotas = $total_a_financiar/4;
    $cinco_cuotas = $total_a_financiar/5;
    //numeros con formato de dinero
    $valor_matricula = number_format($valor_matricula, 0, '', '.');
    $veinte_por_ciento = number_format($veinte_por_ciento, 0, '', '.');
    $tres_cuotas = number_format($tres_cuotas, 0, '', '.');
    $cuatro_cuotas = number_format($cuatro_cuotas, 0, '', '.');
    $cinco_cuotas = number_format($cinco_cuotas, 0, '', '.');
return <<<MESSAGE
    <div style="text-align: justify; font-size: 1.08rem; padding:5%; font-family: 'Century Gothic'">
        <header>
            <h1>¡Estimado estudiante!</h1>
        </header>
        <main>
            <p>Sabemos que los costos de la matrícula representan un impacto en tu flujo de caja. Sin embargo, deseamos presentarte varias opciones para financiarla y hacerla más accesible.</p>
            <h2>Valor de la matrícula:</h2>
            <p>La matrícula para este periodo académico es de <b>$$valor_matricula</b>. Sin embargo, no necesariamente tienes que hacerlo en un solo pago.</p>
            <h3>Requisito inicial:</h3>
            <p>Para poder financiar tu matrícula, debes dar una cuota inicial de mínimo el 20% del valor total, lo que sería <b>$$veinte_por_ciento</b> Este depósito es necesario para asegurarte la matrícula.</p>
            <h3>Opciones de pago:</h3>
            <ul>
                <li>3 cuotas: Puedes pagar la matrícula en 3 cuotas mensuales, cada una de <b>$$tres_cuotas</b>.</li>
                <li>4 cuotas: Puedes pagar la matrícula en 4 cuotas mensuales, cada una de <b>$$cuatro_cuotas</b>.</li>
                <li>5 cuotas: Puedes pagar la matrícula en 5 cuotas mensuales, cada una de <b>$$cinco_cuotas</b>.</li>
            </ul>
            <h3>Beneficios:</h3>
            <ul>
                <li>Puedes dividir el costo de la matrícula en varias partes, lo que facilita el pago.</li>
                <li>Cero “0” por ciento de interés.</li>
                <li>Comodidad de distribuir el costo de tu educación de manera más manejable, permitiéndote concentrarte en tus estudios sin preocupaciones financieras.</li>
                <li>Podemos ayudarte a crear un plan de pago personalizado que se adapte a tus necesidades.</li>
            </ul>
            <h3>¿Qué debes hacer ahora?</h3>
            <p>Si estás interesado en financiar tu matrícula, por favor haz clic en el siguiente enlace <a href="https://ciaf.digital/inscribete/">para completar el formulario de solicitud</a>. Revisa cual opción se ajusta a tus necesidades y acércate a nuestras instalaciones donde podrás formalizar la financiación de tu matrícula.</p>
            <h3>Contacto:</h3>
            <p>Si tienes alguna pregunta o necesitas más información, por favor no dudes en contactarnos al 3126814341. Estamos aquí para ayudarte.</p>
        </main>
        <footer>
            <p>¡Gracias por considerar nuestras opciones de pago y por permitirnos ser tu aliado en tu formación académica!</p>
        </footer>
    </div>
MESSAGE;
}
//visualizar si el template esta quedando bien(diseño)
$mensaje = template_renovacion_matricula(2299000);
if(enviar_correo("sistemasdeinformacion@ciaf.edu.co", "Todo lo que necesitas sobre la renovación de tu Matrícula", $mensaje)){
    echo "enviado";
}else{
    echo "No enviado";
}
?>
