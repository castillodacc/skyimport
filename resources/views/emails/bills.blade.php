<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Importadora Sky</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="white" style="padding: 5px 0 5px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="{{ asset('/img/h1.png') }}" alt="Bienvenido" width="300" height="230" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 5px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px; text-align: center;">
										<b>U.S Cargo el Servicio Courier de Importadora Sky.</b>
									</td>
								</tr>
								<hr/>
								<tr>
									<td style="padding: 5px 0 5px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
										<strong>
											Proceso de facturación de su consolidado:
										</strong>
										<ul>
											<li> Cliente: {{ $consolidated->user->fullName() }}.</li>
											<li> Identificación: {{ $consolidated->user->num_id }}.</li>
											<li> Consolidado n°: {{ $consolidated->number }} </li>
											<li> Peso: {{ $consolidated->weight }}.</li>
											<li> Facturacion total: {{ $consolidated->bill }}.</li>
											<li> Fecha de expedicion de factura: {{ $consolidated->updated_at->format('d/m/Y') }}.</li>
										</ul>
										<p>Recibido:</p>
										<ul>
											@foreach($consolidated->trackings as $tracking)
											<li> Tracking: {{ $tracking->tracking }} - Descripcion: {{ $tracking->description }}.</li>
											@endforeach
										</ul>
									</td>
								</tr>
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="260" valign="top">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td>
																<img src="{{ asset('img/left.gif') }}" alt="" width="100%" height="140" style="display: block;" />
															</td>
														</tr>
														<tr>
															<td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
																La informacion acerca de sus consolidados podra ser consultada en cualquier dispositivo movil o de escritorios de nuestra herramienta web <a href="{{ url('/') }}">{{ url('/') }}</a>.
															</td>
														</tr>
													</table>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">
													&nbsp;
												</td>
												<td width="260" valign="top">
													<table border="0" cellpadding="0" cellspacing="0" width="100%">
														<tr>
															<td>
																<img src="{{ asset('img/right.gif') }}" alt="" width="100%" height="140" style="display: block;" />
															</td>
														</tr>
														<tr>
															<td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
																Usted puede consultarnos los tiempos de envios y estatus de cada uno de sus paquetes, gracias a nuestro novedoso sistema automatizado.
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 0px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
										<p>Gracias y cualquier inquietud no dude en contactarnos.</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#ee4c50" style="padding: 10px 10px 10px 10px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px; text-align: justify;" width="75%">
										<p>
											&reg; 2018 Importadora Sky. All Rights Reserved<br/>
										</p>
										<p>
											COLOMBIA<br>
											Calle 35#29-54 Oficina 806.<br>
											Celular / WhatsApp: 317-5608824.<br>
											U.S.A - OPERATION CENTER<br>
											9759 Misty Plain Drive, San Antonio Texas 78238 U.S.A.<br>
											Phone: (512) 234-7692.<br>
											CHINA - CANTON WINNER.<br>
											Fuwei Building, Guangfo Rd<br>
											Room #522.
											Foshan, Guangdong Province.
										</p>
									</td>
									<td align="right" width="25%">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://twitter.com/importadorasky" style="color: #ffffff;">
														<img src="{{ asset('img/tw.gif') }}" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="https://www.facebook.com/importadorasky/" style="color: #ffffff;">
														<img src="{{ asset('img/fb.gif') }}" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
													</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>