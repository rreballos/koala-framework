<div class="<?=$this->cssClass?>">
    <div class="<?=$this->propCssClass?>">
        <div class="<? if($this->center){ echo $this->position; }?><? if($this->row->flow){?> flow<?}else{?> noFlow<?}?>">
            <? if ($this->image) { ?>
                <div class="image" <? if($this->center){?>style="margin-left: <?=$this->center?>px;margin-right: <?=$this->center?>px"<?}?>><?=$this->component($this->image)?></div>
            <? } ?>
            <div class="text"<? if(!$this->row->flow && !$this->center) {?> style="margin-<?=$this->position?>: <?=$this->imageWidth?>px"<?}?>>
            <?=$this->component($this->text)?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>