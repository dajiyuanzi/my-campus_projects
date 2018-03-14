#include <stdio.h>
#include "calc3.h"
#include "y.tab.h"

// We used AT&T x86-64 instruction
// gcc -S test.c
// gcc -Og -S test.c //-Og least optimized so most same as original code
//this is a stack machine

static int lbl;

int ex(nodeType *p) {
    int lbl1, lbl2;

    if (!p) return 0;
    switch (p->type) {
    case typeCon:       //push the value before some operator to be determined
        printf("\tpushq\t$%d\n", p->con.value);
        break;
    case typeId:        //push the value before some operator to be determined
        printf("\tpushq\t%c\n", p->id.i + 'a');
        break;
    case typeOpr:
        switch (p->opr.oper) {
        case WHILE: //to be noticed, here no needs to jmp after cmp, because the cmp and its jmp will be determined in cmp section at bottom code
            printf("L%03d:\n", lbl1 = lbl++);
            ex(p->opr.op[0]);
            //printf("\tjz\tL%03d\n", lbl2 = lbl++);
            printf("L%03d\n", lbl2 = lbl++);
            ex(p->opr.op[1]);
            printf("\tjmp\tL%03d\n", lbl1); //jmp for continue if cmp section is true (not false 0)
            printf("L%03d:\n", lbl2);
            break;
        case IF: //accoding to the lab doc, jz-jum if equal, cmp-return 0(false) if the cmp not right
            ex(p->opr.op[0]);
            if (p->opr.nops > 2) {  //to be noticed, here no needs to jmp after cmp, because the cmp and its jmp will be determined in cmp section at bottom code
                /* if else */
                //printf("\tjz\tL%03d\n", lbl1 = lbl++); //cmp statement in if is last in but first out than if in stack
                printf("L%03d\n", lbl1 = lbl++);
                ex(p->opr.op[1]);
                printf("\tjmp\tL%03d\n", lbl2 = lbl++); //jmp for continue instead of the jmp after cmp return 0(false)
                printf("L%03d:\n", lbl1);
                ex(p->opr.op[2]);
                printf("L%03d:\n", lbl2);
            } else {
                /* if */
                printf("\tjz\tL%03d\n", lbl1 = lbl++);
                ex(p->opr.op[1]);
                printf("L%03d:\n", lbl1);
            }
            break;
        case PRINT:
            ex(p->opr.op[0]);
            printf("\tmovq\t$format, \t%%rdi\n"); //set string format by first parameter to "printf" func
            printf("\tpopq\t%%rsi\n"); //the value to be printed, taken from stake by 2nd parameter to "printf"
            printf("\txorq\t%%rax, \t%%rax\n"); //zero out rax (important for printf), related to inverted code
            printf("\tcall\tprintf\n");
            break;
        case '=': //pop the value, it means taking value from stake and sending it to a used register near this command
            ex(p->opr.op[1]);
            printf("\tpopq\t%c\n", p->opr.op[0]->id.i + 'a');
            break;
        case UMINUS:  //Negate
            ex(p->opr.op[0]); //firstly pop the value, then push
            printf("\tpopq %%rax\n");
            printf("\tnegq %%rax\n");
            printf("\tpushq %%rax\n");
            break;
        case FACT:
            ex(p->opr.op[0]);
            printf("\tcall fact\n");
            printf("\tpush %%rax\n"); //put the result into stack
            break;
        case LNTWO:
            ex(p->opr.op[0]);
            printf("\tlntwo\n");
            break;
        default:
            ex(p->opr.op[0]);
            ex(p->opr.op[1]);
            switch (p->opr.oper) {
            case GCD:   printf("\tgcd\n"); break;
            case '+': 
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); //zero out registers
                printf("\tpopq\t%%rbx\n"); 
                printf("\tpopq\t%%rax\n"); //rbx is for callee saving
                printf("\taddq\t %%rbx, %%rax\n");
                printf("\tpushq\t%%rax\n");
                break;
            case '-':  
                printf("\txorq\t%%rbx,\t%%rbx\n");  
                printf("\txorq\t%%rax,\t%%rax\n"); //notice: stack is last in but first out. so rbx is the right value, rax is left value
                printf("\tpopq\t%%rbx\n"); 
                printf("\tpopq\t%%rax\n");
                printf("\tsubq\t%%rbx, %%rax\n"); //rax-rbx put result into rax
                printf("\tpushq\t%%rax\n");
                break;
            case '*': 
                printf("\txorq\t%%rbx,\t%%rbx\n");   
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n"); 
                printf("\tpopq\t%%rax\n");
                printf("\timulq\t%%rbx\n"); //mul self-multiply
                printf("\tpushq\t%%rax\n"); 
                break;
            case '/':  
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcqto\n"); // i dont know but it works from stackoverflow: sign extend rax to rdx:rax, cqto (convert quad to oct) in AT&T
                printf("\tidivq\t%%rbx\n"); //rdx will store the remainder num from idiv, rax the quotient
                printf("\tpushq\t%%rax\n");
                break;
            case '<':   
                printf("\txorq\t%%rbx,\t%%rbx\n");
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n"); 
                printf("\tpopq\t%%rax\n"); //notice: stack is last in but first out. so rax is the second value(right->), rbx is frist value(left<-)
                printf("\tcmpq\t%%rbx,\t%%rax\n"); // cmpq: rax(1st value) < rbx(2nd value)
                printf("\tjge\t"); //if <, continue; if not < (>=), jump
                break;
            case '>':   
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcmpq\t%%rbx,\t%%rax\n"); 
                printf("\tjle\t");
                break;
            case GE:    // >=
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcmpq\t%%rbx,\t%%rax\n"); 
                printf("\tjl\t");
                break;
            case LE:    // <=
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcmpq\t%%rbx,\t%%rax\n"); 
                printf("\tjg\t");
                break;
            case NE:   // != 
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcmpq\t%%rbx,\t%%rax\n"); 
                printf("\tje\t");
                break;
            case EQ:   // == 
                printf("\txorq\t%%rbx,\t%%rbx\n"); 
                printf("\txorq\t%%rax,\t%%rax\n"); 
                printf("\tpopq\t%%rbx\n");
                printf("\tpopq\t%%rax\n");
                printf("\tcmpq\t%%rbx,\t%%rax\n"); 
                printf("\tjne\t"); 
                break;
            }
        }
    }
    return 0;
}