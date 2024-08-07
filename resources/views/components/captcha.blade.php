@once
<x-filament::modal id="captcha">
	<x-slot name="heading">
		请完成验证后再继续
	</x-slot>
	<div x-data="{code:'', tips:'请输入验证码', url:''}"
		@captcha-failed.window="code=''; tips='验证失败，请重新输入'; url=$event.detail.url"
		@captcha-load.window="url=$event.detail.url"
		>
		<div class="flex gap-2 py-2">
			<img x-bind:src="url" @click.throttle="$wire.realodCaptcha" class="cursor-pointer">
			<x-filament::input.wrapper>
				<x-filament::input type="text" x-bind:placeholder="tips" x-model="code" />
			</x-filament::input.wrapper>
		</div>
		<div class="pt-2">
			<x-filament::button @click.throttle="$wire.checkCaptcha(code)">验证</x-filament::button>
		</div>
	</div>
</x-filament::modal>
@endonce
