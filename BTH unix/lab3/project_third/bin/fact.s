
# setup data section (initialised data)
.data
	format: .asciz  "%d\n"  # declare and initialise format string to use with printf

# setup data section (uninitialised data)
.bss
	i:	.quad	0       # declare and initialise 8 byte variables

	a:	.quad	0
	b:	.quad	0       # the provided label (b) can be used to reference the space in memory
	
	c:	.quad	0
	d:	.quad	0
	n:	.quad	0
	s:	.quad	0
	t:	.quad	0
#   result: .quad   0       # declare 8 byte variable

# start text section (the actual code goes into this section)
.text
.globl main             # make label main globally visible (for example, visible for linker)

main:	pushq	$0
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$1
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$2
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$3
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$4
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$5
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$6
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$7
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$8
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$9
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$10
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	pushq	$11
	call fact
	push %rax
	movq	$format, 	%rdi
	popq	%rsi
	xorq	%rax, 	%rax
	call	printf
	call exit
