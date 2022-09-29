<title>Planilla {{$reservation->id}}</title>
<div style="float:left;width:50%">
  <img src="{{public_path('assets/elite.png')}}" width="200">
</div>
<div style="float:right;width:50%" align="right">
<b>www.eliteparking.es</b><br>
Calle Gumercindo Llorente 77, Madrid</br>
28022 de Madrid<br>
Correo: contacto@eliteparking.es<br>
Reservas: +34 910 94 57 30<br>
</div>
<br><br><br><br><br>
<center>
  <p><b>COMPROBANTE DE RESERVA</b></p>
</center>

<hr>

<center>
  <b>Reserva web Num:</b> {{$reservation->id}} <b>Fecha:</b> {{$reservation->reception_date}} <b>Hora:</b> {{$reservation->reception_time}}
</center>

<hr>

<p><b>Datos de la reserva:</b></p>

<p><b>Nombre del conductor principal:</b> {{$reservation->client->person->name}}</p>

<p><b>DNI/NIE/PASAPORTE:</b> {{$reservation->client->person->identificationType->name}} {{$reservation->client->person->identification_card}} </p>

<p><b>Móvil de contacto:</b> {{$reservation->client->person->phone}}</p>

<p><b>Mail de contacto:</b> {{$reservation->client->person->email}}</p>

<p><b>Matrícula:</b> {{$reservation->vehicle->plaque}} <b>Marca:</b> {{$reservation->vehicle->brand->name}} <b>Modelo:</b> {{$reservation->vehicle->model->name}} <b>Color:</b> {{$reservation->vehicle->color}}</p>

<p><b>Fecha de recogida:</b> {{$reservation->reception_date}} <b>Hora de recogida:</b> {{$reservation->reception_time}} <b>Terminal de salida:</b> {{$reservation->reception_terminal_id}}</p>

<p><b>Fecha de llegada del vuelo de vuelta:</b> {{$reservation->devolution_date}} <b>Hora de recogida:</b> {{$reservation->devolution_time}} <b>Terminal de recogida:</b> {{$reservation->devolution_terminal_id}}</p>

<p><b>Coste de reserva:</b> {{$reservation->price}} &#8364 <b>Forma de pago:</b> {{$reservation->payment_method}}</p>

<p><b>Observación:</b> {{$reservation->observation}}</p>

<p>Le solicitamos comunicarse con nuestro servicio de asistencia en aeropuerto (+34 623 16 46 56) 20 - 30 minutos antes de llegar a la entrega de su vehículo y al aterrizar de su viaje de vuelta para evitar esperas.</p>

<p>La recepción y devolución de coches se realiza entre las <u>5:00 am y las 1:00 am</u>. Posterior a nuestro horario conllevará un recargo de un día de servicio y el coche será entregado en nuestro horario laborable.</p>

<br><br><br><br><br>
<center>
  <table align="center">
    <tr>
      <td><img src="{{public_path('assets/carro.png')}}" width="200"></td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td><center>____________________</center></td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td><center>____________________</center></td>
    </tr>
    <tr>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td>  </td>
      <td><center><b>Conductor<br>EliteParking</b></center></td>
      <td> </td>
      <td> </td>
      <td> </td>
      <td><center><b>Cliente</b></center></td>
    </tr>
    
  </table>
  <br>
  <p>Puede consultar sus Condiciones Generales del Contrato a través del portal <u>www.eliteparking.es</u></p>
</center>
