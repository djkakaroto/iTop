<?php
/* Driver template for the PHP_OQLParser_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class OQLParser_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof OQLParser_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof OQLParser_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof OQLParser_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof OQLParser_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class OQLParser_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here

// declare_class is output here
#line 24 "..\oql-parser.y"
class OQLParserRaw#line 102 "..\oql-parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const UNION                          =  1;
    const SELECT                         =  2;
    const AS_ALIAS                       =  3;
    const FROM                           =  4;
    const COMA                           =  5;
    const WHERE                          =  6;
    const JOIN                           =  7;
    const ON                             =  8;
    const EQ                             =  9;
    const BELOW                          = 10;
    const BELOW_STRICT                   = 11;
    const NOT_BELOW                      = 12;
    const NOT_BELOW_STRICT               = 13;
    const ABOVE                          = 14;
    const ABOVE_STRICT                   = 15;
    const NOT_ABOVE                      = 16;
    const NOT_ABOVE_STRICT               = 17;
    const PAR_OPEN                       = 18;
    const PAR_CLOSE                      = 19;
    const INTERVAL                       = 20;
    const F_SECOND                       = 21;
    const F_MINUTE                       = 22;
    const F_HOUR                         = 23;
    const F_DAY                          = 24;
    const F_MONTH                        = 25;
    const F_YEAR                         = 26;
    const DOT                            = 27;
    const ARROW                          = 28;
    const VARNAME                        = 29;
    const NAME                           = 30;
    const NUMVAL                         = 31;
    const MATH_MINUS                     = 32;
    const HEXVAL                         = 33;
    const STRVAL                         = 34;
    const REGEXP                         = 35;
    const NOT_EQ                         = 36;
    const LOG_AND                        = 37;
    const LOG_OR                         = 38;
    const MATH_DIV                       = 39;
    const MATH_MULT                      = 40;
    const MATH_PLUS                      = 41;
    const GT                             = 42;
    const LT                             = 43;
    const GE                             = 44;
    const LE                             = 45;
    const LIKE                           = 46;
    const NOT_LIKE                       = 47;
    const BITWISE_LEFT_SHIFT             = 48;
    const BITWISE_RIGHT_SHIFT            = 49;
    const BITWISE_AND                    = 50;
    const BITWISE_OR                     = 51;
    const BITWISE_XOR                    = 52;
    const IN                             = 53;
    const NOT_IN                         = 54;
    const F_IF                           = 55;
    const F_ELT                          = 56;
    const F_COALESCE                     = 57;
    const F_ISNULL                       = 58;
    const F_CONCAT                       = 59;
    const F_SUBSTR                       = 60;
    const F_TRIM                         = 61;
    const F_DATE                         = 62;
    const F_DATE_FORMAT                  = 63;
    const F_CURRENT_DATE                 = 64;
    const F_NOW                          = 65;
    const F_TIME                         = 66;
    const F_TO_DAYS                      = 67;
    const F_FROM_DAYS                    = 68;
    const F_DATE_ADD                     = 69;
    const F_DATE_SUB                     = 70;
    const F_ROUND                        = 71;
    const F_FLOOR                        = 72;
    const F_INET_ATON                    = 73;
    const F_INET_NTOA                    = 74;
    const YY_NO_ACTION = 295;
    const YY_ACCEPT_ACTION = 294;
    const YY_ERROR_ACTION = 293;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 610;
static public $yy_action = array(
 /*     0 */    28,  125,   47,  180,  180,   54,   42,  120,   62,   73,
 /*    10 */    11,   38,   37,   66,  128,   68,    7,   48,  123,  119,
 /*    20 */    69,   88,  164,  162,  155,  153,  145,  111,  125,  110,
 /*    30 */    76,  108,  107,  129,  102,  116,  115,  114,  112,   67,
 /*    40 */   152,  138,   87,   87,  127,  117,  131,  132,   29,  139,
 /*    50 */   140,   59,    3,  106,  105,  104,  103,  134,  118,  135,
 /*    60 */   154,  156,  157,  158,  159,  160,  161,  165,  166,  167,
 /*    70 */   168,  169,  163,    7,   58,    6,  109,   73,   87,  164,
 /*    80 */   162,  155,   86,   57,  111,  125,  110,   76,  108,  107,
 /*    90 */    14,   15,   21,   22,   17,   18,   20,   19,   16,   52,
 /*   100 */    56,   44,   45,   45,   87,   55,  112,   67,   45,   54,
 /*   110 */   106,  105,  104,  103,  134,  118,  135,  154,  156,  157,
 /*   120 */   158,  159,  160,  161,  165,  166,  167,  168,  169,  163,
 /*   130 */     7,   87,   41,    5,   73,  129,  164,  162,  155,   91,
 /*   140 */    57,  111,  125,  110,   76,  108,  107,   85,  131,  132,
 /*   150 */     8,   40,    2,   92,   39,   46,   12,   80,  124,   13,
 /*   160 */    45,   99,   87,  112,   67,  130,  126,  106,  105,  104,
 /*   170 */   103,  134,  118,  135,  154,  156,  157,  158,  159,  160,
 /*   180 */   161,  165,  166,  167,  168,  169,  163,  294,  100,   63,
 /*   190 */   170,   73,    9,   79,  235,   50,   10,   68,   34,   49,
 /*   200 */   123,  119,   69,    1,  121,   43,   27,   82,   23,   42,
 /*   210 */    35,  141,  142,   81,   28,   42,  102,  116,  115,  114,
 /*   220 */   112,   67,   73,   87,   53,    8,   83,   45,   68,   31,
 /*   230 */    49,  123,  119,   69,   60,   84,    4,   27,  133,   23,
 /*   240 */   130,   35,  113,  241,  241,   90,  241,  102,  116,  115,
 /*   250 */   114,  112,   67,   73,   51,  241,  241,  241,  241,   68,
 /*   260 */    33,   49,  123,  119,   69,  241,  241,  241,   27,  241,
 /*   270 */    23,   73,   35,  241,  241,   61,  241,   71,  102,  116,
 /*   280 */   115,  114,  112,   67,  241,  241,  122,   73,  241,  241,
 /*   290 */   241,  241,  241,   68,   34,   49,  123,  119,   69,  241,
 /*   300 */   112,   67,   27,  241,   23,  241,   35,  241,  241,  241,
 /*   310 */   241,  241,  102,  116,  115,  114,  112,   67,   73,  241,
 /*   320 */   241,  241,  241,  241,   68,   31,   49,  123,  119,   69,
 /*   330 */   241,  241,   73,   27,  241,   23,  241,   35,   77,  241,
 /*   340 */   241,   89,  241,  102,  116,  115,  114,  112,   67,   73,
 /*   350 */   241,  241,  241,  241,  241,   68,   32,   49,  123,  119,
 /*   360 */    69,  112,   67,  241,   27,  241,   23,   73,   35,  241,
 /*   370 */   241,  241,  241,   65,  102,  116,  115,  114,  112,   67,
 /*   380 */   241,  241,  241,   73,  241,  241,  241,  241,  241,   68,
 /*   390 */    25,   49,  123,  119,   69,  241,  112,   67,   27,  241,
 /*   400 */    23,  241,   35,  241,  241,  241,  241,  241,  102,  116,
 /*   410 */   115,  114,  112,   67,   73,  241,  241,  241,  241,  241,
 /*   420 */    68,   30,   49,  123,  119,   69,  241,  241,   73,   27,
 /*   430 */   241,   23,  241,   35,   72,  241,  241,  241,  241,  102,
 /*   440 */   116,  115,  114,  112,   67,   73,  241,  241,  241,  241,
 /*   450 */   241,   68,  241,   49,  123,  119,   69,  112,   67,  241,
 /*   460 */    27,  241,   23,  241,   36,  241,  241,  241,  241,  241,
 /*   470 */   102,  116,  115,  114,  112,   67,  241,  241,  241,   73,
 /*   480 */   241,  241,  241,  241,  241,   68,  241,   49,  123,  119,
 /*   490 */    69,  241,  241,  241,   27,  241,   24,   93,   94,   95,
 /*   500 */    96,   97,   98,  241,  102,  116,  115,  114,  112,   67,
 /*   510 */    73,  241,  241,  241,  129,  241,   68,  241,   49,  123,
 /*   520 */   119,   69,  241,  241,  241,   26,  137,  131,  132,  241,
 /*   530 */   241,  241,  241,  241,  241,  102,  116,  115,  114,  112,
 /*   540 */    67,   73,  241,  241,  241,   73,  241,   64,  241,  147,
 /*   550 */   241,   78,  143,  144,  241,  241,  241,  241,  146,  148,
 /*   560 */   149,  150,  151,  136,  101,  241,   73,  241,  241,  241,
 /*   570 */   112,   67,   74,  241,  112,   67,  241,   73,  241,   73,
 /*   580 */   241,  241,  241,   75,  241,   70,  241,  241,  241,  241,
 /*   590 */   241,  241,  241,  241,  241,  112,   67,  241,  241,  241,
 /*   600 */   241,  241,  241,  241,  241,  241,  112,   67,  112,   67,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,   30,    3,    4,    5,   28,    7,   77,   78,   80,
 /*    10 */    96,    1,   80,   80,   19,   86,   18,   88,   89,   90,
 /*    20 */    91,   82,   24,   25,   26,  111,  112,   29,   30,   31,
 /*    30 */    32,   33,   34,   38,  105,  106,  107,  108,  109,  110,
 /*    40 */    39,   40,  110,  110,   53,   54,   51,   52,   80,   48,
 /*    50 */    49,   83,    6,   55,   56,   57,   58,   59,   60,   61,
 /*    60 */    62,   63,   64,   65,   66,   67,   68,   69,   70,   71,
 /*    70 */    72,   73,   74,   18,   80,   20,   31,   80,  110,   24,
 /*    80 */    25,   26,   85,   86,   29,   30,   31,   32,   33,   34,
 /*    90 */     9,   10,   11,   12,   13,   14,   15,   16,   17,   81,
 /*   100 */    81,   80,   84,   84,  110,   81,  109,  110,   84,   28,
 /*   110 */    55,   56,   57,   58,   59,   60,   61,   62,   63,   64,
 /*   120 */    65,   66,   67,   68,   69,   70,   71,   72,   73,   74,
 /*   130 */    18,  110,   80,    5,   80,   38,   24,   25,   26,   85,
 /*   140 */    86,   29,   30,   31,   32,   33,   34,   19,   51,   52,
 /*   150 */   101,    3,    5,  104,    4,    5,    8,   81,  110,    8,
 /*   160 */    84,   82,  110,  109,  110,  116,   19,   55,   56,   57,
 /*   170 */    58,   59,   60,   61,   62,   63,   64,   65,   66,   67,
 /*   180 */    68,   69,   70,   71,   72,   73,   74,   76,   77,   78,
 /*   190 */    79,   80,  100,   80,   27,   27,   98,   86,   87,   88,
 /*   200 */    89,   90,   91,   18,   82,    3,   95,  115,   97,    7,
 /*   210 */    99,  113,  114,   37,    2,    7,  105,  106,  107,  108,
 /*   220 */   109,  110,   80,  110,   81,  101,   50,   84,   86,   87,
 /*   230 */    88,   89,   90,   91,   92,   82,   18,   95,   94,   97,
 /*   240 */   116,   99,  110,  117,  117,  103,  117,  105,  106,  107,
 /*   250 */   108,  109,  110,   80,   93,  117,  117,  117,  117,   86,
 /*   260 */    87,   88,   89,   90,   91,  117,  117,  117,   95,  117,
 /*   270 */    97,   80,   99,  117,  117,  102,  117,   86,  105,  106,
 /*   280 */   107,  108,  109,  110,  117,  117,   79,   80,  117,  117,
 /*   290 */   117,  117,  117,   86,   87,   88,   89,   90,   91,  117,
 /*   300 */   109,  110,   95,  117,   97,  117,   99,  117,  117,  117,
 /*   310 */   117,  117,  105,  106,  107,  108,  109,  110,   80,  117,
 /*   320 */   117,  117,  117,  117,   86,   87,   88,   89,   90,   91,
 /*   330 */   117,  117,   80,   95,  117,   97,  117,   99,   86,  117,
 /*   340 */   117,  103,  117,  105,  106,  107,  108,  109,  110,   80,
 /*   350 */   117,  117,  117,  117,  117,   86,   87,   88,   89,   90,
 /*   360 */    91,  109,  110,  117,   95,  117,   97,   80,   99,  117,
 /*   370 */   117,  117,  117,   86,  105,  106,  107,  108,  109,  110,
 /*   380 */   117,  117,  117,   80,  117,  117,  117,  117,  117,   86,
 /*   390 */    87,   88,   89,   90,   91,  117,  109,  110,   95,  117,
 /*   400 */    97,  117,   99,  117,  117,  117,  117,  117,  105,  106,
 /*   410 */   107,  108,  109,  110,   80,  117,  117,  117,  117,  117,
 /*   420 */    86,   87,   88,   89,   90,   91,  117,  117,   80,   95,
 /*   430 */   117,   97,  117,   99,   86,  117,  117,  117,  117,  105,
 /*   440 */   106,  107,  108,  109,  110,   80,  117,  117,  117,  117,
 /*   450 */   117,   86,  117,   88,   89,   90,   91,  109,  110,  117,
 /*   460 */    95,  117,   97,  117,   99,  117,  117,  117,  117,  117,
 /*   470 */   105,  106,  107,  108,  109,  110,  117,  117,  117,   80,
 /*   480 */   117,  117,  117,  117,  117,   86,  117,   88,   89,   90,
 /*   490 */    91,  117,  117,  117,   95,  117,   97,   21,   22,   23,
 /*   500 */    24,   25,   26,  117,  105,  106,  107,  108,  109,  110,
 /*   510 */    80,  117,  117,  117,   38,  117,   86,  117,   88,   89,
 /*   520 */    90,   91,  117,  117,  117,   95,    9,   51,   52,  117,
 /*   530 */   117,  117,  117,  117,  117,  105,  106,  107,  108,  109,
 /*   540 */   110,   80,  117,  117,  117,   80,  117,   86,  117,   32,
 /*   550 */   117,   86,   35,   36,  117,  117,  117,  117,   41,   42,
 /*   560 */    43,   44,   45,   46,   47,  117,   80,  117,  117,  117,
 /*   570 */   109,  110,   86,  117,  109,  110,  117,   80,  117,   80,
 /*   580 */   117,  117,  117,   86,  117,   86,  117,  117,  117,  117,
 /*   590 */   117,  117,  117,  117,  117,  109,  110,  117,  117,  117,
 /*   600 */   117,  117,  117,  117,  117,  117,  109,  110,  109,  110,
);
    const YY_SHIFT_USE_DFLT = -30;
    const YY_SHIFT_MAX = 78;
    static public $yy_shift_ofst = array(
 /*     0 */    -2,   55,   55,  112,  112,  112,  112,  112,  112,  112,
 /*    10 */   112,  112,  -29,  -29,  -29,  -29,  -29,  -29,  -29,  -29,
 /*    20 */   -29,  -29,  -29,  517,  517,  476,    1,    1,  -29,   -1,
 /*    30 */    -5,   97,   97,   97,   97,  176,  176,  202,  212,  -29,
 /*    40 */   -29,  208,  -29,  -29,  208,  208,  -29,  -29,   -9,   -9,
 /*    50 */   -29,  218,   46,   46,  -29,   46,   46,   81,  148,  150,
 /*    60 */   147,  128,   10,   10,  -23,  -23,  151,  167,  -23,  185,
 /*    70 */   -23,  -23,  -23,  168,  -23,  -23,   45,  -23,  -23,
);
    const YY_REDUCE_USE_DFLT = -87;
    const YY_REDUCE_MAX = 56;
    static public $yy_reduce_ofst = array(
 /*     0 */   111,  142,  238,  207,  173,  269,  303,  334,  365,  399,
 /*    10 */   430,  -71,   -3,   54,  497,  465,  499,  461,  486,  191,
 /*    20 */   348,  287,  252,   98,   98,   49,  -86,  -86,  -32,  143,
 /*    30 */   124,  124,  124,  124,  124,   92,   92,   18,  -70,  -68,
 /*    40 */   -67,   19,   -6,   21,   24,   76,  113,   52,  161,  161,
 /*    50 */   132,  144,  153,  122,   48,   79,  -61,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(2, 18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 1 */ array(18, 20, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 2 */ array(18, 20, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 3 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 4 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 5 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 6 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 7 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 8 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 9 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 10 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 11 */ array(18, 24, 25, 26, 29, 30, 31, 32, 33, 34, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, ),
        /* 12 */ array(30, ),
        /* 13 */ array(30, ),
        /* 14 */ array(30, ),
        /* 15 */ array(30, ),
        /* 16 */ array(30, ),
        /* 17 */ array(30, ),
        /* 18 */ array(30, ),
        /* 19 */ array(30, ),
        /* 20 */ array(30, ),
        /* 21 */ array(30, ),
        /* 22 */ array(30, ),
        /* 23 */ array(9, 32, 35, 36, 41, 42, 43, 44, 45, 46, 47, ),
        /* 24 */ array(9, 32, 35, 36, 41, 42, 43, 44, 45, 46, 47, ),
        /* 25 */ array(21, 22, 23, 24, 25, 26, 38, 51, 52, ),
        /* 26 */ array(39, 40, 48, 49, ),
        /* 27 */ array(39, 40, 48, 49, ),
        /* 28 */ array(30, ),
        /* 29 */ array(3, 4, 5, 7, ),
        /* 30 */ array(19, 38, 51, 52, ),
        /* 31 */ array(38, 51, 52, ),
        /* 32 */ array(38, 51, 52, ),
        /* 33 */ array(38, 51, 52, ),
        /* 34 */ array(38, 51, 52, ),
        /* 35 */ array(37, 50, ),
        /* 36 */ array(37, 50, ),
        /* 37 */ array(3, 7, ),
        /* 38 */ array(2, ),
        /* 39 */ array(30, ),
        /* 40 */ array(30, ),
        /* 41 */ array(7, ),
        /* 42 */ array(30, ),
        /* 43 */ array(30, ),
        /* 44 */ array(7, ),
        /* 45 */ array(7, ),
        /* 46 */ array(30, ),
        /* 47 */ array(30, ),
        /* 48 */ array(53, 54, ),
        /* 49 */ array(53, 54, ),
        /* 50 */ array(30, ),
        /* 51 */ array(18, ),
        /* 52 */ array(6, ),
        /* 53 */ array(6, ),
        /* 54 */ array(30, ),
        /* 55 */ array(6, ),
        /* 56 */ array(6, ),
        /* 57 */ array(9, 10, 11, 12, 13, 14, 15, 16, 17, 28, ),
        /* 58 */ array(3, 8, ),
        /* 59 */ array(4, 5, ),
        /* 60 */ array(5, 19, ),
        /* 61 */ array(5, 19, ),
        /* 62 */ array(1, ),
        /* 63 */ array(1, ),
        /* 64 */ array(28, ),
        /* 65 */ array(28, ),
        /* 66 */ array(8, ),
        /* 67 */ array(27, ),
        /* 68 */ array(28, ),
        /* 69 */ array(18, ),
        /* 70 */ array(28, ),
        /* 71 */ array(28, ),
        /* 72 */ array(28, ),
        /* 73 */ array(27, ),
        /* 74 */ array(28, ),
        /* 75 */ array(28, ),
        /* 76 */ array(31, ),
        /* 77 */ array(28, ),
        /* 78 */ array(28, ),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
        /* 102 */ array(),
        /* 103 */ array(),
        /* 104 */ array(),
        /* 105 */ array(),
        /* 106 */ array(),
        /* 107 */ array(),
        /* 108 */ array(),
        /* 109 */ array(),
        /* 110 */ array(),
        /* 111 */ array(),
        /* 112 */ array(),
        /* 113 */ array(),
        /* 114 */ array(),
        /* 115 */ array(),
        /* 116 */ array(),
        /* 117 */ array(),
        /* 118 */ array(),
        /* 119 */ array(),
        /* 120 */ array(),
        /* 121 */ array(),
        /* 122 */ array(),
        /* 123 */ array(),
        /* 124 */ array(),
        /* 125 */ array(),
        /* 126 */ array(),
        /* 127 */ array(),
        /* 128 */ array(),
        /* 129 */ array(),
        /* 130 */ array(),
        /* 131 */ array(),
        /* 132 */ array(),
        /* 133 */ array(),
        /* 134 */ array(),
        /* 135 */ array(),
        /* 136 */ array(),
        /* 137 */ array(),
        /* 138 */ array(),
        /* 139 */ array(),
        /* 140 */ array(),
        /* 141 */ array(),
        /* 142 */ array(),
        /* 143 */ array(),
        /* 144 */ array(),
        /* 145 */ array(),
        /* 146 */ array(),
        /* 147 */ array(),
        /* 148 */ array(),
        /* 149 */ array(),
        /* 150 */ array(),
        /* 151 */ array(),
        /* 152 */ array(),
        /* 153 */ array(),
        /* 154 */ array(),
        /* 155 */ array(),
        /* 156 */ array(),
        /* 157 */ array(),
        /* 158 */ array(),
        /* 159 */ array(),
        /* 160 */ array(),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
        /* 164 */ array(),
        /* 165 */ array(),
        /* 166 */ array(),
        /* 167 */ array(),
        /* 168 */ array(),
        /* 169 */ array(),
        /* 170 */ array(),
);
    static public $yy_default = array(
 /*     0 */   293,  216,  293,  293,  293,  293,  293,  293,  293,  293,
 /*    10 */   293,  293,  293,  293,  293,  293,  293,  293,  293,  293,
 /*    20 */   293,  293,  293,  209,  210,  293,  208,  207,  293,  186,
 /*    30 */   293,  219,  215,  214,  198,  211,  212,  186,  293,  293,
 /*    40 */   293,  186,  293,  293,  186,  185,  293,  293,  206,  205,
 /*    50 */   293,  293,  183,  183,  293,  183,  183,  293,  293,  293,
 /*    60 */   293,  293,  174,  172,  193,  191,  293,  231,  200,  293,
 /*    70 */   197,  196,  195,  293,  194,  189,  293,  192,  190,  181,
 /*    80 */   184,  249,  250,  265,  178,  213,  188,  235,  177,  218,
 /*    90 */   217,  187,  220,  221,  222,  223,  224,  225,  226,  179,
 /*   100 */   171,  262,  227,  273,  272,  271,  270,  241,  240,  239,
 /*   110 */   238,  236,  233,  232,  230,  229,  228,  269,  275,  201,
 /*   120 */   175,  176,  182,  199,  234,  237,  202,  268,  203,  251,
 /*   130 */   252,  266,  267,  204,  274,  276,  261,  247,  254,  263,
 /*   140 */   264,  244,  245,  246,  248,  243,  255,  256,  257,  258,
 /*   150 */   259,  260,  253,  242,  277,  284,  278,  279,  280,  281,
 /*   160 */   282,  283,  285,  292,  286,  287,  288,  289,  290,  291,
 /*   170 */   173,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 118;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 171;
    const YYNRULE = 122;
    const YYERRORSYMBOL = 75;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx = -1;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'UNION',         'SELECT',        'AS_ALIAS',    
  'FROM',          'COMA',          'WHERE',         'JOIN',        
  'ON',            'EQ',            'BELOW',         'BELOW_STRICT',
  'NOT_BELOW',     'NOT_BELOW_STRICT',  'ABOVE',         'ABOVE_STRICT',
  'NOT_ABOVE',     'NOT_ABOVE_STRICT',  'PAR_OPEN',      'PAR_CLOSE',   
  'INTERVAL',      'F_SECOND',      'F_MINUTE',      'F_HOUR',      
  'F_DAY',         'F_MONTH',       'F_YEAR',        'DOT',         
  'ARROW',         'VARNAME',       'NAME',          'NUMVAL',      
  'MATH_MINUS',    'HEXVAL',        'STRVAL',        'REGEXP',      
  'NOT_EQ',        'LOG_AND',       'LOG_OR',        'MATH_DIV',    
  'MATH_MULT',     'MATH_PLUS',     'GT',            'LT',          
  'GE',            'LE',            'LIKE',          'NOT_LIKE',    
  'BITWISE_LEFT_SHIFT',  'BITWISE_RIGHT_SHIFT',  'BITWISE_AND',   'BITWISE_OR',  
  'BITWISE_XOR',   'IN',            'NOT_IN',        'F_IF',        
  'F_ELT',         'F_COALESCE',    'F_ISNULL',      'F_CONCAT',    
  'F_SUBSTR',      'F_TRIM',        'F_DATE',        'F_DATE_FORMAT',
  'F_CURRENT_DATE',  'F_NOW',         'F_TIME',        'F_TO_DAYS',   
  'F_FROM_DAYS',   'F_DATE_ADD',    'F_DATE_SUB',    'F_ROUND',     
  'F_FLOOR',       'F_INET_ATON',   'F_INET_NTOA',   'error',       
  'result',        'union',         'query',         'condition',   
  'class_name',    'join_statement',  'where_statement',  'class_list',  
  'join_item',     'join_condition',  'field_id',      'expression_prio4',
  'expression_basic',  'scalar',        'var_name',      'func_name',   
  'arg_list',      'list_operator',  'list',          'expression_prio1',
  'operator1',     'expression_prio2',  'operator2',     'expression_prio3',
  'operator3',     'operator4',     'list_items',    'argument',    
  'interval_unit',  'num_scalar',    'str_scalar',    'num_value',   
  'str_value',     'basic_field_id',  'name',          'num_operator1',
  'bitwise_operator1',  'num_operator2',  'str_operator',  'bitwise_operator3',
  'bitwise_operator4',
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "result ::= union",
 /*   1 */ "result ::= query",
 /*   2 */ "result ::= condition",
 /*   3 */ "union ::= query UNION query",
 /*   4 */ "union ::= query UNION union",
 /*   5 */ "query ::= SELECT class_name join_statement where_statement",
 /*   6 */ "query ::= SELECT class_name AS_ALIAS class_name join_statement where_statement",
 /*   7 */ "query ::= SELECT class_list FROM class_name join_statement where_statement",
 /*   8 */ "query ::= SELECT class_list FROM class_name AS_ALIAS class_name join_statement where_statement",
 /*   9 */ "class_list ::= class_name",
 /*  10 */ "class_list ::= class_list COMA class_name",
 /*  11 */ "where_statement ::= WHERE condition",
 /*  12 */ "where_statement ::=",
 /*  13 */ "join_statement ::= join_item join_statement",
 /*  14 */ "join_statement ::= join_item",
 /*  15 */ "join_statement ::=",
 /*  16 */ "join_item ::= JOIN class_name AS_ALIAS class_name ON join_condition",
 /*  17 */ "join_item ::= JOIN class_name ON join_condition",
 /*  18 */ "join_condition ::= field_id EQ field_id",
 /*  19 */ "join_condition ::= field_id BELOW field_id",
 /*  20 */ "join_condition ::= field_id BELOW_STRICT field_id",
 /*  21 */ "join_condition ::= field_id NOT_BELOW field_id",
 /*  22 */ "join_condition ::= field_id NOT_BELOW_STRICT field_id",
 /*  23 */ "join_condition ::= field_id ABOVE field_id",
 /*  24 */ "join_condition ::= field_id ABOVE_STRICT field_id",
 /*  25 */ "join_condition ::= field_id NOT_ABOVE field_id",
 /*  26 */ "join_condition ::= field_id NOT_ABOVE_STRICT field_id",
 /*  27 */ "condition ::= expression_prio4",
 /*  28 */ "expression_basic ::= scalar",
 /*  29 */ "expression_basic ::= field_id",
 /*  30 */ "expression_basic ::= var_name",
 /*  31 */ "expression_basic ::= func_name PAR_OPEN arg_list PAR_CLOSE",
 /*  32 */ "expression_basic ::= PAR_OPEN expression_prio4 PAR_CLOSE",
 /*  33 */ "expression_basic ::= expression_basic list_operator list",
 /*  34 */ "expression_prio1 ::= expression_basic",
 /*  35 */ "expression_prio1 ::= expression_prio1 operator1 expression_basic",
 /*  36 */ "expression_prio2 ::= expression_prio1",
 /*  37 */ "expression_prio2 ::= expression_prio2 operator2 expression_prio1",
 /*  38 */ "expression_prio3 ::= expression_prio2",
 /*  39 */ "expression_prio3 ::= expression_prio3 operator3 expression_prio2",
 /*  40 */ "expression_prio4 ::= expression_prio3",
 /*  41 */ "expression_prio4 ::= expression_prio4 operator4 expression_prio3",
 /*  42 */ "list ::= PAR_OPEN list_items PAR_CLOSE",
 /*  43 */ "list_items ::= expression_prio4",
 /*  44 */ "list_items ::= list_items COMA expression_prio4",
 /*  45 */ "arg_list ::=",
 /*  46 */ "arg_list ::= argument",
 /*  47 */ "arg_list ::= arg_list COMA argument",
 /*  48 */ "argument ::= expression_prio4",
 /*  49 */ "argument ::= INTERVAL expression_prio4 interval_unit",
 /*  50 */ "interval_unit ::= F_SECOND",
 /*  51 */ "interval_unit ::= F_MINUTE",
 /*  52 */ "interval_unit ::= F_HOUR",
 /*  53 */ "interval_unit ::= F_DAY",
 /*  54 */ "interval_unit ::= F_MONTH",
 /*  55 */ "interval_unit ::= F_YEAR",
 /*  56 */ "scalar ::= num_scalar",
 /*  57 */ "scalar ::= str_scalar",
 /*  58 */ "num_scalar ::= num_value",
 /*  59 */ "str_scalar ::= str_value",
 /*  60 */ "basic_field_id ::= name",
 /*  61 */ "basic_field_id ::= class_name DOT name",
 /*  62 */ "field_id ::= basic_field_id",
 /*  63 */ "field_id ::= field_id ARROW name",
 /*  64 */ "class_name ::= name",
 /*  65 */ "var_name ::= VARNAME",
 /*  66 */ "name ::= NAME",
 /*  67 */ "num_value ::= NUMVAL",
 /*  68 */ "num_value ::= MATH_MINUS NUMVAL",
 /*  69 */ "num_value ::= HEXVAL",
 /*  70 */ "str_value ::= STRVAL",
 /*  71 */ "operator1 ::= num_operator1",
 /*  72 */ "operator1 ::= bitwise_operator1",
 /*  73 */ "operator2 ::= num_operator2",
 /*  74 */ "operator2 ::= str_operator",
 /*  75 */ "operator2 ::= REGEXP",
 /*  76 */ "operator2 ::= EQ",
 /*  77 */ "operator2 ::= NOT_EQ",
 /*  78 */ "operator3 ::= LOG_AND",
 /*  79 */ "operator3 ::= bitwise_operator3",
 /*  80 */ "operator4 ::= LOG_OR",
 /*  81 */ "operator4 ::= bitwise_operator4",
 /*  82 */ "num_operator1 ::= MATH_DIV",
 /*  83 */ "num_operator1 ::= MATH_MULT",
 /*  84 */ "num_operator2 ::= MATH_PLUS",
 /*  85 */ "num_operator2 ::= MATH_MINUS",
 /*  86 */ "num_operator2 ::= GT",
 /*  87 */ "num_operator2 ::= LT",
 /*  88 */ "num_operator2 ::= GE",
 /*  89 */ "num_operator2 ::= LE",
 /*  90 */ "str_operator ::= LIKE",
 /*  91 */ "str_operator ::= NOT_LIKE",
 /*  92 */ "bitwise_operator1 ::= BITWISE_LEFT_SHIFT",
 /*  93 */ "bitwise_operator1 ::= BITWISE_RIGHT_SHIFT",
 /*  94 */ "bitwise_operator3 ::= BITWISE_AND",
 /*  95 */ "bitwise_operator4 ::= BITWISE_OR",
 /*  96 */ "bitwise_operator4 ::= BITWISE_XOR",
 /*  97 */ "list_operator ::= IN",
 /*  98 */ "list_operator ::= NOT_IN",
 /*  99 */ "func_name ::= F_IF",
 /* 100 */ "func_name ::= F_ELT",
 /* 101 */ "func_name ::= F_COALESCE",
 /* 102 */ "func_name ::= F_ISNULL",
 /* 103 */ "func_name ::= F_CONCAT",
 /* 104 */ "func_name ::= F_SUBSTR",
 /* 105 */ "func_name ::= F_TRIM",
 /* 106 */ "func_name ::= F_DATE",
 /* 107 */ "func_name ::= F_DATE_FORMAT",
 /* 108 */ "func_name ::= F_CURRENT_DATE",
 /* 109 */ "func_name ::= F_NOW",
 /* 110 */ "func_name ::= F_TIME",
 /* 111 */ "func_name ::= F_TO_DAYS",
 /* 112 */ "func_name ::= F_FROM_DAYS",
 /* 113 */ "func_name ::= F_YEAR",
 /* 114 */ "func_name ::= F_MONTH",
 /* 115 */ "func_name ::= F_DAY",
 /* 116 */ "func_name ::= F_DATE_ADD",
 /* 117 */ "func_name ::= F_DATE_SUB",
 /* 118 */ "func_name ::= F_ROUND",
 /* 119 */ "func_name ::= F_FLOOR",
 /* 120 */ "func_name ::= F_INET_ATON",
 /* 121 */ "func_name ::= F_INET_NTOA",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param OQLParser_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new OQLParser_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new OQLParser_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new OQLParser_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for ($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 4 ),
  array( 'lhs' => 78, 'rhs' => 6 ),
  array( 'lhs' => 78, 'rhs' => 6 ),
  array( 'lhs' => 78, 'rhs' => 8 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 82, 'rhs' => 2 ),
  array( 'lhs' => 82, 'rhs' => 0 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 0 ),
  array( 'lhs' => 84, 'rhs' => 6 ),
  array( 'lhs' => 84, 'rhs' => 4 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 4 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 1 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 3 ),
  array( 'lhs' => 99, 'rhs' => 1 ),
  array( 'lhs' => 99, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 94, 'rhs' => 3 ),
  array( 'lhs' => 102, 'rhs' => 1 ),
  array( 'lhs' => 102, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 0 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 103, 'rhs' => 1 ),
  array( 'lhs' => 103, 'rhs' => 3 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 104, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 105, 'rhs' => 1 ),
  array( 'lhs' => 106, 'rhs' => 1 ),
  array( 'lhs' => 109, 'rhs' => 1 ),
  array( 'lhs' => 109, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 90, 'rhs' => 1 ),
  array( 'lhs' => 110, 'rhs' => 1 ),
  array( 'lhs' => 107, 'rhs' => 1 ),
  array( 'lhs' => 107, 'rhs' => 2 ),
  array( 'lhs' => 107, 'rhs' => 1 ),
  array( 'lhs' => 108, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 100, 'rhs' => 1 ),
  array( 'lhs' => 100, 'rhs' => 1 ),
  array( 'lhs' => 101, 'rhs' => 1 ),
  array( 'lhs' => 101, 'rhs' => 1 ),
  array( 'lhs' => 111, 'rhs' => 1 ),
  array( 'lhs' => 111, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 113, 'rhs' => 1 ),
  array( 'lhs' => 114, 'rhs' => 1 ),
  array( 'lhs' => 114, 'rhs' => 1 ),
  array( 'lhs' => 112, 'rhs' => 1 ),
  array( 'lhs' => 112, 'rhs' => 1 ),
  array( 'lhs' => 115, 'rhs' => 1 ),
  array( 'lhs' => 116, 'rhs' => 1 ),
  array( 'lhs' => 116, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 0,
        2 => 0,
        3 => 3,
        4 => 3,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        43 => 9,
        46 => 9,
        10 => 10,
        44 => 10,
        47 => 10,
        11 => 11,
        12 => 12,
        15 => 12,
        13 => 13,
        14 => 14,
        16 => 16,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        27 => 27,
        28 => 27,
        29 => 27,
        30 => 27,
        34 => 27,
        36 => 27,
        38 => 27,
        40 => 27,
        48 => 27,
        50 => 27,
        51 => 27,
        52 => 27,
        53 => 27,
        54 => 27,
        55 => 27,
        56 => 27,
        57 => 27,
        62 => 27,
        31 => 31,
        32 => 32,
        33 => 33,
        35 => 33,
        37 => 33,
        39 => 33,
        41 => 33,
        42 => 42,
        45 => 45,
        49 => 49,
        58 => 58,
        59 => 58,
        60 => 60,
        61 => 61,
        63 => 63,
        64 => 64,
        99 => 64,
        100 => 64,
        101 => 64,
        102 => 64,
        103 => 64,
        104 => 64,
        105 => 64,
        106 => 64,
        107 => 64,
        108 => 64,
        109 => 64,
        110 => 64,
        111 => 64,
        112 => 64,
        113 => 64,
        114 => 64,
        115 => 64,
        116 => 64,
        117 => 64,
        118 => 64,
        119 => 64,
        120 => 64,
        121 => 64,
        65 => 65,
        66 => 66,
        67 => 67,
        68 => 68,
        69 => 69,
        70 => 70,
        71 => 71,
        72 => 71,
        73 => 71,
        74 => 71,
        75 => 71,
        76 => 71,
        77 => 71,
        78 => 71,
        79 => 71,
        80 => 71,
        81 => 71,
        82 => 71,
        83 => 71,
        84 => 71,
        85 => 71,
        86 => 71,
        87 => 71,
        88 => 71,
        89 => 71,
        90 => 71,
        91 => 71,
        92 => 71,
        93 => 71,
        94 => 71,
        95 => 71,
        96 => 71,
        97 => 71,
        98 => 71,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 29 "..\oql-parser.y"
    function yy_r0(){ $this->my_result = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1474 "..\oql-parser.php"
#line 33 "..\oql-parser.y"
    function yy_r3(){
	$this->_retvalue = new OqlUnionQuery($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);
    }
#line 1479 "..\oql-parser.php"
#line 40 "..\oql-parser.y"
    function yy_r5(){
	$this->_retvalue = new OqlObjectQuery($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -1]->minor, array($this->yystack[$this->yyidx + -2]->minor));
    }
#line 1484 "..\oql-parser.php"
#line 43 "..\oql-parser.y"
    function yy_r6(){
	$this->_retvalue = new OqlObjectQuery($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -1]->minor, array($this->yystack[$this->yyidx + -2]->minor));
    }
#line 1489 "..\oql-parser.php"
#line 47 "..\oql-parser.y"
    function yy_r7(){
	$this->_retvalue = new OqlObjectQuery($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -4]->minor);
    }
#line 1494 "..\oql-parser.php"
#line 50 "..\oql-parser.y"
    function yy_r8(){
	$this->_retvalue = new OqlObjectQuery($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -6]->minor);
    }
#line 1499 "..\oql-parser.php"
#line 55 "..\oql-parser.y"
    function yy_r9(){
	$this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);
    }
#line 1504 "..\oql-parser.php"
#line 58 "..\oql-parser.y"
    function yy_r10(){
	array_push($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);
	$this->_retvalue = $this->yystack[$this->yyidx + -2]->minor;
    }
#line 1510 "..\oql-parser.php"
#line 63 "..\oql-parser.y"
    function yy_r11(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;    }
#line 1513 "..\oql-parser.php"
#line 64 "..\oql-parser.y"
    function yy_r12(){ $this->_retvalue = null;    }
#line 1516 "..\oql-parser.php"
#line 66 "..\oql-parser.y"
    function yy_r13(){
	// insert the join statement on top of the existing list
	array_unshift($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -1]->minor);
	// and return the updated array
	$this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1524 "..\oql-parser.php"
#line 72 "..\oql-parser.y"
    function yy_r14(){
	$this->_retvalue = Array($this->yystack[$this->yyidx + 0]->minor);
    }
#line 1529 "..\oql-parser.php"
#line 78 "..\oql-parser.y"
    function yy_r16(){
	// create an array with one single item
	$this->_retvalue = new OqlJoinSpec($this->yystack[$this->yyidx + -4]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);
    }
#line 1535 "..\oql-parser.php"
#line 83 "..\oql-parser.y"
    function yy_r17(){
	// create an array with one single item
	$this->_retvalue = new OqlJoinSpec($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);
    }
#line 1541 "..\oql-parser.php"
#line 88 "..\oql-parser.y"
    function yy_r18(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, '=', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1544 "..\oql-parser.php"
#line 89 "..\oql-parser.y"
    function yy_r19(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'BELOW', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1547 "..\oql-parser.php"
#line 90 "..\oql-parser.y"
    function yy_r20(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'BELOW_STRICT', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1550 "..\oql-parser.php"
#line 91 "..\oql-parser.y"
    function yy_r21(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'NOT_BELOW', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1553 "..\oql-parser.php"
#line 92 "..\oql-parser.y"
    function yy_r22(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'NOT_BELOW_STRICT', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1556 "..\oql-parser.php"
#line 93 "..\oql-parser.y"
    function yy_r23(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'ABOVE', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1559 "..\oql-parser.php"
#line 94 "..\oql-parser.y"
    function yy_r24(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'ABOVE_STRICT', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1562 "..\oql-parser.php"
#line 95 "..\oql-parser.y"
    function yy_r25(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'NOT_ABOVE', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1565 "..\oql-parser.php"
#line 96 "..\oql-parser.y"
    function yy_r26(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, 'NOT_ABOVE_STRICT', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1568 "..\oql-parser.php"
#line 98 "..\oql-parser.y"
    function yy_r27(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1571 "..\oql-parser.php"
#line 103 "..\oql-parser.y"
    function yy_r31(){ $this->_retvalue = new FunctionOqlExpression($this->yystack[$this->yyidx + -3]->minor, $this->yystack[$this->yyidx + -1]->minor);     }
#line 1574 "..\oql-parser.php"
#line 104 "..\oql-parser.y"
    function yy_r32(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1577 "..\oql-parser.php"
#line 105 "..\oql-parser.y"
    function yy_r33(){ $this->_retvalue = new BinaryOqlExpression($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1580 "..\oql-parser.php"
#line 120 "..\oql-parser.y"
    function yy_r42(){
	$this->_retvalue = new ListOqlExpression($this->yystack[$this->yyidx + -1]->minor);
    }
#line 1585 "..\oql-parser.php"
#line 131 "..\oql-parser.y"
    function yy_r45(){
	$this->_retvalue = array();
    }
#line 1590 "..\oql-parser.php"
#line 142 "..\oql-parser.y"
    function yy_r49(){ $this->_retvalue = new IntervalOqlExpression($this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1593 "..\oql-parser.php"
#line 154 "..\oql-parser.y"
    function yy_r58(){ $this->_retvalue = new ScalarOqlExpression($this->yystack[$this->yyidx + 0]->minor);     }
#line 1596 "..\oql-parser.php"
#line 157 "..\oql-parser.y"
    function yy_r60(){ $this->_retvalue = new FieldOqlExpression($this->yystack[$this->yyidx + 0]->minor);     }
#line 1599 "..\oql-parser.php"
#line 158 "..\oql-parser.y"
    function yy_r61(){ $this->_retvalue = new FieldOqlExpression($this->yystack[$this->yyidx + 0]->minor, $this->yystack[$this->yyidx + -2]->minor);     }
#line 1602 "..\oql-parser.php"
#line 161 "..\oql-parser.y"
    function yy_r63(){ $this->_retvalue = new ExternalFieldOqlExpression($this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1605 "..\oql-parser.php"
#line 163 "..\oql-parser.y"
    function yy_r64(){ $this->_retvalue=$this->yystack[$this->yyidx + 0]->minor;     }
#line 1608 "..\oql-parser.php"
#line 166 "..\oql-parser.y"
    function yy_r65(){ $this->_retvalue = new VariableOqlExpression(substr($this->yystack[$this->yyidx + 0]->minor, 1));     }
#line 1611 "..\oql-parser.php"
#line 168 "..\oql-parser.y"
    function yy_r66(){
	if ($this->yystack[$this->yyidx + 0]->minor[0] == '`')
	{
		$name = substr($this->yystack[$this->yyidx + 0]->minor, 1, strlen($this->yystack[$this->yyidx + 0]->minor) - 2);
	}
	else
	{
		$name = $this->yystack[$this->yyidx + 0]->minor;
	}
	$this->_retvalue = new OqlName($name, $this->m_iColPrev);
    }
#line 1624 "..\oql-parser.php"
#line 179 "..\oql-parser.y"
    function yy_r67(){$this->_retvalue=(int)$this->yystack[$this->yyidx + 0]->minor;    }
#line 1627 "..\oql-parser.php"
#line 180 "..\oql-parser.y"
    function yy_r68(){$this->_retvalue=(int)-$this->yystack[$this->yyidx + 0]->minor;    }
#line 1630 "..\oql-parser.php"
#line 181 "..\oql-parser.y"
    function yy_r69(){$this->_retvalue=new OqlHexValue($this->yystack[$this->yyidx + 0]->minor);    }
#line 1633 "..\oql-parser.php"
#line 182 "..\oql-parser.y"
    function yy_r70(){$this->_retvalue=stripslashes(substr($this->yystack[$this->yyidx + 0]->minor, 1, strlen($this->yystack[$this->yyidx + 0]->minor) - 2));    }
#line 1636 "..\oql-parser.php"
#line 185 "..\oql-parser.y"
    function yy_r71(){$this->_retvalue=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1639 "..\oql-parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //OQLParser_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for ($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new OQLParser_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 25 "..\oql-parser.y"
 
throw new OQLParserException($this->m_sSourceQuery, $this->m_iLine, $this->m_iCol, $this->tokenName($yymajor), $TOKEN);
#line 1755 "..\oql-parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int   $yymajor      the token number
     * @param mixed $yytokenvalue the token value
     * @param mixed ...           any extra arguments that should be passed to handlers
     *
     * @return void
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new OQLParser_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(
                self::$yyTraceFILE,
                "%sInput %s\n",
                self::$yyTracePrompt,
                self::$yyTokenName[$yymajor]
            );
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL
                && !$this->yy_is_expected_token($yymajor)
            ) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(
                        self::$yyTraceFILE,
                        "%sSyntax Error!\n",
                        self::$yyTracePrompt
                    );
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ) {
                        if (self::$yyTraceFILE) {
                            fprintf(
                                self::$yyTraceFILE,
                                "%sDiscard input token %s\n",
                                self::$yyTracePrompt,
                                self::$yyTokenName[$yymajor]
                            );
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0
                            && $yymx != self::YYERRORSYMBOL
                            && ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                        ) {
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}
#line 243 "..\oql-parser.y"


class OQLParserException extends OQLException
{
	public function __construct($sInput, $iLine, $iCol, $sTokenName, $sTokenValue)
	{
		$sIssue = "Unexpected token $sTokenName";
	
		parent::__construct($sIssue, $sInput, $iLine, $iCol, $sTokenValue);
	}
}

class OQLParser extends OQLParserRaw
{
	// dirty, but working for us (no other mean to get the final result :-(
   protected $my_result;

	public function GetResult()
	{
		return $this->my_result;
	}

   // More info on the source query and the current position while parsing it
   // Data used when an exception is raised
	protected $m_iLine; // still not used
	protected $m_iCol;
	protected $m_iColPrev; // this is the interesting one, because the parser will reduce on the next token
	protected $m_sSourceQuery;

	public function __construct($sQuery)
	{
		$this->m_iLine = 0;
		$this->m_iCol = 0;
		$this->m_iColPrev = 0;
		$this->m_sSourceQuery = $sQuery;
		// no constructor - parent::__construct();
	}
	
	public function doParse($token, $value, $iCurrPosition = 0)
	{
		$this->m_iColPrev = $this->m_iCol;
		$this->m_iCol = $iCurrPosition;

		return parent::DoParse($token, $value);
	}

	public function doFinish()
	{
		$this->doParse(0, 0);
		return $this->my_result;
	}
	
	public function __destruct()
	{
		// Bug in the original destructor, causing an infinite loop !
		// This is a real issue when a fatal error occurs on the first token (the error could not be seen)
		if (is_null($this->yyidx))
		{
			$this->yyidx = -1;
		}
		parent::__destruct();
	}
}

#line 1988 "..\oql-parser.php"
