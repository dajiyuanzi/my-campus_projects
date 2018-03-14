/*The code refer to the old PPT*/	
.text
.global fact /* make the fun global and used anywhere*/

fact:   
		movq 	8(%rsp), %rcx   /* rsp: stack top pointer, rcx: argument4 to save value, this register is for loop command */
        movq 	$1, %rax        /* rax: store result, and firstly store 1 as init result */

        cmpq $0, %rcx			/* Check rcx: jump to return if the used rcx=0  0!==1 */
        je retrn            

l1:     mulq %rcx               /* mul: rax(last result)*rcx=rax, and result set in to rax */
        loop l1                 /* loop: use %cx, %cx-=1 and jump*/
        
        jmp retrn               /* Jump to return rax value */
 
retrn:  ret                     /* return the result in rax. ax is base register and it often stores result data */
