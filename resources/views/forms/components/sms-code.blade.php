<x-dynamic-component
	:component="$getFieldWrapperView()"
	:field="$field">
	<div x-data="
		{
			mobile: '{{$mobile ?? ''}}',
			count: 0,
			get label() {
				return this.count ? `${this.count} 秒后可再次发送` : '发送验证码';
			},
			countDown() {
				if (this.count > 0) return;
				this.count = 60;
				$wire.sendSmsCode(this.mobile);
				let timer = setInterval(() => (--this.count <= 0) && clearInterval(timer), 1000)
			}
		}">

		<div class="pt-3">
			<x-filament::input.wrapper>
				<x-filament::input type="text" x-model="mobile" placeholder="输入手机号码" />
			</x-filament::input.wrapper>
		</div>
		<div class="pt-3">
			<x-filament::input.wrapper>
				<x-filament::input type="text" wire:model="{{ $getStatePath() }}" placeholder="输入手机验证码" />
				<x-slot name="suffix">
					<button type="button" :disabled="count > 0" x-text="label" @click="countDown"></button>
				</x-slot>
			</x-filament::input.wrapper>
			{{--
				<x-filament::button color="gray" x-bind:class="{'opacity-50': count > 0}" @click="countDown" x-text="label" />
				<x-filament::button color="gray" disabled x-show="count" x-text="label" />
				<x-filament::button @click="countDown" x-show="!count" x-text="label" />
			--}}
		</div>
	</div>
</x-dynamic-component>
