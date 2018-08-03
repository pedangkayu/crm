<aside class="page-aside" style="width: 24%; height: 100%; position: fixed; right: 0px; padding-bottom: 61px; z-index: 999; border-radius: 0px; overflow: scroll; overflow-x: hidden; background: rgb(255, 255, 255); border-left: 3px solid rgb(238, 238, 238);">
	<div class="ciuis-body-scroller nano ps-container ps-theme-default" data-ps-id="ac74da58-8e1c-6b15-4582-65d6b23ba5fc">
		<div class="panel-default panel-table borderten lead-manager-head" style="overflow: scroll;">
			<div class="panel-heading">
				<div id="details" class="clearfix" style="font-size: 12px;">
					<div id="proposal">
						<h1><?php echo lang('proposalprefix'),'-',str_pad($proposals['id'], 6, '0', STR_PAD_LEFT); ?></h1>
						<div class="date"><?php echo lang('dateofissuance')?>:<?php switch($settings['dateformat']){case 'yy.mm.dd': echo _rdate($proposals['date']);break; 
							case 'dd.mm.yy': echo _udate($proposals['date']); break;case 'yy-mm-dd': echo _mdate($proposals['date']); break;case 'dd-mm-yy': echo _cdate($proposals['date']); break;case 'yy/mm/dd': echo _zdate($proposals['date']); break;case 'dd/mm/yy': echo _kdate($proposals['date']); break;
							}?></div>
						<div class="date text-bold"><?php echo lang('opentill')?>:<?php switch($settings['dateformat']){case 'yy.mm.dd': echo _rdate($proposals['opentill']);break;case 'dd.mm.yy': echo _udate($proposals['opentill']); break;case 'yy-mm-dd': echo _mdate($proposals['opentill']); break;case 'dd-mm-yy': echo _cdate($proposals['opentill']); break;case 'yy/mm/dd': echo _zdate($proposals['opentill']); break;case 'dd/mm/yy': echo _kdate($proposals['opentill']); break;}?></div>
					</div>
					<div id="company">
						<h2 class="crm-company-name"><?php echo $settings['company'] ?></h2>
						<div><?php echo $settings['address'] ?></div>
						<div><?php echo lang('phone')?>:</b><?php echo $settings['phone'] ?></div>
						<div><a href="mailto:<?php echo $settings['email'] ?>"><?php echo $settings['email'] ?></a></div>
					</div>
					<div id="client">
						<div class="proposalto"><b><?php echo lang('proposalto'); ?>:</b></div>
						<h2 class="toname"><?php if($proposals['relation_type'] == 'customer'){if($proposals['customercompany']===NULL){echo $proposals['namesurname'];} else echo $proposals['customercompany'];} ?><?php if($proposals['relation_type'] == 'lead'){echo $proposals['leadname'];} ?></h2>
						<div class="address"><?php echo $proposals['toaddress']; ?></div>
						<div class="email"><a href="mailto:<?php echo $proposals['toemail']; ?>"><?php echo $proposals['toemail']; ?></a></div>
					</div>
				</div>
				<hr>
				<div class="btn-group col-md-12 md-pr-0 md-pl-0 md-pb-10">
					<button data-proposal="<?php echo $proposals['id']; ?>" class="btn accept-proposal btn-default btn-big col-md-4"><i class="icon ion-checkmark-round"></i> <?php echo lang('accept')?></button>
					<button data-proposal="<?php echo $proposals['id']; ?>" class="btn decline-proposal btn-default btn-big col-md-4"><i class="icon ion-close-round"></i> <?php echo lang('decline')?> </button>
					<a target="_blank" href="<?php echo base_url('share/pdf_proposal/'.$proposals['token'].''); ?>" class="btn btn-default btn-big col-md-4"><i class="icon ion-document"></i> <?php echo lang('pdf')?> </a>
				</div>
				<?php foreach($comments as $comment){?>
				
				<div class="comment-block">
				  <div class="comment-dialog">
					<p class="text"><?php echo $comment['content'] ?></p>
				  </div>
				</div>
				<?php }?>
				
				<div style="<?php if($proposals['comment']!=1){echo 'display:none;';}?>">
				<?php echo form_open_multipart('share/customercomment',array("class"=>"")); ?>
				<div class="form-group">
				<textarea name="content" class="form-control"><?php $this->input->post('content')?></textarea>
				<input type="hidden" name="relation" value="<?php echo $proposals['id'] ?>">
				</div>
				<button type="submit" class="btn btn-lg btn-default col-md-12"><?php echo lang('addcomment');?></button>
				<?php echo form_close(); ?>
				
				</div>
			</div>
		</div>
	</div>
</aside>