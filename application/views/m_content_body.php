<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box grey">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i><?php echo($apli_producto); ?></div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
								<a href="#portlet-config" data-toggle="modal" class="config"></a>
								<a href="javascript:;" class="reload"></a>
								<a href="javascript:;" class="remove"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<!--div class="btn-group">
									<button id="sample_editable_1_new" class="btn green">
										Añadir <i class="icon-plus"></i>
									</button>
								</div-->
								<div class="btn-group pull-right">
									<button class="btn dropdown-toggle" data-toggle="dropdown">Herramientas <i class="icon-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right">
									<li><a href="#">Imprimir</a></li>
									<li><a href="#">Guardar como PDF</a></li>
									<li><a href="#">Exportar a Excel</a></li>
								</ul>
								</div>
							</div>
							<?php echo($table); ?>
							
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
